<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Color;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    // Listare toate produsele - /shop
    public function index(Request $request)
    {
        $query = Product::with(['categories', 'colors'])
            ->where('is_active', true);

        // Filtru după categorie (inclusiv subcategorii)
        if ($request->has('category') && $request->category) {
            $category = Category::with('children')->find($request->category);
            if ($category) {
                // Dacă categoria este părinte (nu are parent_id), include și subcategoriile
                if ($category->isParent()) {
                    // Include categoria părinte + toate subcategoriile
                    $categoryIds = $category->children->pluck('id')->push($category->id);
                    $query->whereHas('categories', function ($q) use ($categoryIds) {
                        $q->whereIn('categories.id', $categoryIds);
                    });
                } else {
                    // Este subcategorie - arată DOAR produsele din această subcategorie
                    $query->whereHas('categories', function ($q) use ($category) {
                        $q->where('categories.id', $category->id);
                    });
                }
            }
        }

        // Filtru după culoare
        if ($request->has('color') && $request->color) {
            $query->whereHas('colors', function ($q) use ($request) {
                $q->where('colors.id', $request->color);
            });
        }

        // Filtru search text
        if ($request->has('search') && $request->search) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('title', 'LIKE', "%{$searchTerm}%")
                    ->orWhere('description', 'LIKE', "%{$searchTerm}%");
            });
        }

        // Filtru preț minim (folosește prețul final - cu reducere dacă există)
        if ($request->has('min_price') && $request->min_price !== null && $request->min_price !== '') {
            $query->whereRaw('CASE WHEN discount_price > 0 THEN discount_price ELSE price END >= ?', [$request->min_price]);
        }

        // Filtru preț maxim (folosește prețul final - cu reducere dacă există)
        if ($request->has('max_price') && $request->max_price !== null && $request->max_price !== '') {
            $query->whereRaw('CASE WHEN discount_price > 0 THEN discount_price ELSE price END <= ?', [$request->max_price]);
        }

        // Sortare
        if ($request->has('sort')) {
            switch ($request->sort) {
                case 'price_asc':
                    $query->orderByRaw('CASE WHEN discount_price > 0 THEN discount_price ELSE price END ASC');
                    break;
                case 'price_desc':
                    $query->orderByRaw('CASE WHEN discount_price > 0 THEN discount_price ELSE price END DESC');
                    break;
                case 'name_asc':
                    $query->orderBy('title', 'asc');
                    break;
                case 'name_desc':
                    $query->orderBy('title', 'desc');
                    break;
                default:
                    $query->latest();
            }
        } else {
            $query->latest();
        }

        $products = $query->paginate(12)->withQueryString();

        // Obține range-ul de prețuri pentru filtre (folosește prețul final)
        $priceRange = Product::where('is_active', true)
            ->selectRaw('MIN(CASE WHEN discount_price > 0 THEN discount_price ELSE price END) as min, MAX(CASE WHEN discount_price > 0 THEN discount_price ELSE price END) as max')
            ->first();

        // Obține categoriile principale cu subcategoriile lor
        $categories = Category::with(['children' => function ($query) {
            $query->withCount('products');
        }])
            ->whereNull('parent_id')
            ->where('is_active', true)
            ->withCount('products')
            ->orderBy('name')
            ->get();

        $colors = Color::where('is_active', true)
            ->orderBy('name')
            ->get();

        $selectedCategory = $request->category ? Category::with('parent', 'children')->find($request->category) : null;
        $selectedColor = $request->color ? Color::find($request->color) : null;

        return view('shop.index', compact('products', 'categories', 'colors', 'selectedCategory', 'selectedColor', 'priceRange'));
    }

    // Listare produse după categorie - /shop/bijuterii sau /shop/cercei
    public function category(Request $request, $categorySlug)
    {
        $category = Category::where('slug', $categorySlug)
            ->where('is_active', true)
            ->with(['parent', 'children' => function ($query) {
                $query->where('is_active', true)->withCount('products');
            }])
            ->firstOrFail();

        // Dacă este categorie părinte și NU e selectată o subcategorie specifică
        if ($category->isParent() && !$request->has('subcategory')) {
            // Arată toate produsele din categoria părinte + subcategorii
            $categoryIds = $category->children->pluck('id')->push($category->id);
            $query = Product::whereHas('categories', function ($q) use ($categoryIds) {
                $q->whereIn('categories.id', $categoryIds);
            })
                ->where('is_active', true)
                ->with(['categories', 'colors']);
        }
        // Dacă este categorie părinte dar e selectată o subcategorie
        elseif ($category->isParent() && $request->has('subcategory')) {
            $subcategory = Category::where('id', $request->subcategory)
                ->where('parent_id', $category->id)
                ->where('is_active', true)
                ->first();

            if ($subcategory) {
                // Arată DOAR produsele din subcategoria selectată
                $query = Product::whereHas('categories', function ($q) use ($subcategory) {
                    $q->where('categories.id', $subcategory->id);
                })
                    ->where('is_active', true)
                    ->with(['categories', 'colors']);
            } else {
                // Subcategorie invalidă, arată produsele categoriei principale + subcategorii
                $categoryIds = $category->children->pluck('id')->push($category->id);
                $query = Product::whereHas('categories', function ($q) use ($categoryIds) {
                    $q->whereIn('categories.id', $categoryIds);
                })
                    ->where('is_active', true)
                    ->with(['categories', 'colors']);
            }
        }
        // Dacă este subcategorie (child)
        else {
            // Arată DOAR produsele din această subcategorie
            $query = Product::whereHas('categories', function ($q) use ($category) {
                $q->where('categories.id', $category->id);
            })
                ->where('is_active', true)
                ->with(['categories', 'colors']);
        }

        // Filtru după culoare
        if ($request->has('color') && $request->color) {
            $query->whereHas('colors', function ($q) use ($request) {
                $q->where('colors.id', $request->color);
            });
        }

        // Filtru search text
        if ($request->has('search') && $request->search) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('title', 'LIKE', "%{$searchTerm}%")
                    ->orWhere('description', 'LIKE', "%{$searchTerm}%");
            });
        }

        // Filtru preț minim (folosește prețul final - cu reducere dacă există)
        if ($request->has('min_price') && $request->min_price !== null && $request->min_price !== '') {
            $query->whereRaw('CASE WHEN discount_price > 0 THEN discount_price ELSE price END >= ?', [$request->min_price]);
        }

        // Filtru preț maxim (folosește prețul final - cu reducere dacă există)
        if ($request->has('max_price') && $request->max_price !== null && $request->max_price !== '') {
            $query->whereRaw('CASE WHEN discount_price > 0 THEN discount_price ELSE price END <= ?', [$request->max_price]);
        }

        // Sortare
        if ($request->has('sort')) {
            switch ($request->sort) {
                case 'price_asc':
                    $query->orderByRaw('CASE WHEN discount_price > 0 THEN discount_price ELSE price END ASC');
                    break;
                case 'price_desc':
                    $query->orderByRaw('CASE WHEN discount_price > 0 THEN discount_price ELSE price END DESC');
                    break;
                case 'name_asc':
                    $query->orderBy('title', 'asc');
                    break;
                case 'name_desc':
                    $query->orderBy('title', 'desc');
                    break;
                default:
                    $query->latest();
            }
        } else {
            $query->latest();
        }

        $products = $query->paginate(12)->withQueryString();

        // Obține range-ul de prețuri pentru categoria curentă (folosește prețul final)
        if ($category->isParent() && !$request->has('subcategory')) {
            $categoryIds = $category->children->pluck('id')->push($category->id);
            $priceRange = Product::whereHas('categories', function ($q) use ($categoryIds) {
                $q->whereIn('categories.id', $categoryIds);
            })
                ->where('is_active', true)
                ->selectRaw('MIN(CASE WHEN discount_price > 0 THEN discount_price ELSE price END) as min, MAX(CASE WHEN discount_price > 0 THEN discount_price ELSE price END) as max')
                ->first();
        } else {
            $categoryId = $request->has('subcategory')
                ? $request->subcategory
                : $category->id;

            $priceRange = Product::whereHas('categories', function ($q) use ($categoryId) {
                $q->where('categories.id', $categoryId);
            })
                ->where('is_active', true)
                ->selectRaw('MIN(CASE WHEN discount_price > 0 THEN discount_price ELSE price END) as min, MAX(CASE WHEN discount_price > 0 THEN discount_price ELSE price END) as max')
                ->first();
        }

        // Categorii pentru sidebar
        $categories = Category::with(['children' => function ($query) {
            $query->withCount('products');
        }])
            ->whereNull('parent_id')
            ->where('is_active', true)
            ->withCount('products')
            ->orderBy('name')
            ->get();

        $colors = Color::where('is_active', true)
            ->orderBy('name')
            ->get();

        $selectedColor = $request->color ? Color::find($request->color) : null;
        $selectedSubcategory = $request->subcategory ? Category::find($request->subcategory) : null;

        return view('shop.category', compact('products', 'category', 'categories', 'colors', 'selectedColor', 'selectedSubcategory', 'priceRange'));
    }

    // Detalii produs cu categorie - /shop/animale/lesa
    public function showByCategory($categorySlug, $productSlug)
    {
        // Verificăm dacă e categoria "uncategorized" (produse fără categorie)
        if ($categorySlug === 'uncategorized') {
            $product = Product::where('slug', $productSlug)
                ->where('is_active', true)
                ->withCount('approvedReviews')
                ->with(['categories', 'colors', 'approvedReviews.user'])
                ->firstOrFail();

            $userReview = Auth::check() ? $product->reviews()->where('user_id', Auth::id())->first() : null;

            return view('shop.show', compact('product', 'userReview'));
        }

        // Categorie normală
        $category = Category::where('slug', $categorySlug)
            ->where('is_active', true)
            ->firstOrFail();

        $product = Product::whereHas('categories', function ($query) use ($category) {
            $query->where('categories.id', $category->id);
        })
            ->where('slug', $productSlug)
            ->where('is_active', true)
            ->withCount('approvedReviews')
            ->with(['categories', 'colors', 'approvedReviews.user'])
            ->firstOrFail();

        $userReview = Auth::check() ? $product->reviews()->where('user_id', Auth::id())->first() : null;

        return view('shop.show', compact('product', 'category', 'userReview'));
    }
}
