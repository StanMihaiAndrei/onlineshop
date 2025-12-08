<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Color;
use App\Models\Product;
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
            $category = Category::find($request->category);
            if ($category) {
                // Dacă este categorie părinte, include și produsele din subcategorii
                if ($category->isParent() && $request->get('include_subcategories', true)) {
                    $categoryIds = $category->children->pluck('id')->push($category->id);
                    $query->whereHas('categories', function($q) use ($categoryIds) {
                        $q->whereIn('categories.id', $categoryIds);
                    });
                } else {
                    // Doar categoria specificată
                    $query->whereHas('categories', function($q) use ($request) {
                        $q->where('categories.id', $request->category);
                    });
                }
            }
        }

        // Filtru după culoare
        if ($request->has('color') && $request->color) {
            $query->whereHas('colors', function($q) use ($request) {
                $q->where('colors.id', $request->color);
            });
        }

        // Filtru search text
        if ($request->has('search') && $request->search) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('title', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('description', 'LIKE', "%{$searchTerm}%");
            });
        }

        // Filtru preț minim
        if ($request->has('min_price') && $request->min_price !== null && $request->min_price !== '') {
            $query->where('price', '>=', $request->min_price);
        }

        // Filtru preț maxim
        if ($request->has('max_price') && $request->max_price !== null && $request->max_price !== '') {
            $query->where('price', '<=', $request->max_price);
        }

        // Sortare
        if ($request->has('sort')) {
            switch ($request->sort) {
                case 'price_asc':
                    $query->orderBy('price', 'asc');
                    break;
                case 'price_desc':
                    $query->orderBy('price', 'desc');
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
        
        // Obține range-ul de prețuri pentru filtre
        $priceRange = Product::where('is_active', true)->selectRaw('MIN(price) as min, MAX(price) as max')->first();
        
        // Obține categoriile principale cu subcategoriile lor
        $categories = Category::with(['children' => function($query) {
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

    // Listare produse după categorie - /shop/animale
    public function category(Request $request, $categorySlug)
    {
        $category = Category::where('slug', $categorySlug)
            ->where('is_active', true)
            ->with(['children' => function($query) {
                $query->where('is_active', true)->withCount('products');
            }])
            ->firstOrFail();
        
        // Filtru după subcategorie dacă e specificată
        if ($request->has('subcategory') && $request->subcategory) {
            $subcategory = Category::where('id', $request->subcategory)
                ->where('parent_id', $category->id)
                ->where('is_active', true)
                ->first();
            
            if ($subcategory) {
                $query = Product::whereHas('categories', function($q) use ($subcategory) {
                        $q->where('categories.id', $subcategory->id);
                    })
                    ->where('is_active', true)
                    ->with(['categories', 'colors']);
            } else {
                // Subcategorie invalidă, afișează produsele categoriei principale
                $categoryIds = $category->children->pluck('id')->push($category->id);
                $query = Product::whereHas('categories', function($q) use ($categoryIds) {
                        $q->whereIn('categories.id', $categoryIds);
                    })
                    ->where('is_active', true)
                    ->with(['categories', 'colors']);
            }
        } else {
            // Include produsele din categoria principală și subcategorii
            $categoryIds = $category->children->pluck('id')->push($category->id);
            $query = Product::whereHas('categories', function($q) use ($categoryIds) {
                    $q->whereIn('categories.id', $categoryIds);
                })
                ->where('is_active', true)
                ->with(['categories', 'colors']);
        }

        // Filtru după culoare
        if ($request->has('color') && $request->color) {
            $query->whereHas('colors', function($q) use ($request) {
                $q->where('colors.id', $request->color);
            });
        }

        // Filtru search text
        if ($request->has('search') && $request->search) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('title', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('description', 'LIKE', "%{$searchTerm}%");
            });
        }

        // Filtru preț minim
        if ($request->has('min_price') && $request->min_price !== null && $request->min_price !== '') {
            $query->where('price', '>=', $request->min_price);
        }

        // Filtru preț maxim
        if ($request->has('max_price') && $request->max_price !== null && $request->max_price !== '') {
            $query->where('price', '<=', $request->max_price);
        }

        // Sortare
        if ($request->has('sort')) {
            switch ($request->sort) {
                case 'price_asc':
                    $query->orderBy('price', 'asc');
                    break;
                case 'price_desc':
                    $query->orderBy('price', 'desc');
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
        
        // Obține range-ul de prețuri pentru categoria curentă
        $categoryIds = $category->children->pluck('id')->push($category->id);
        $priceRange = Product::whereHas('categories', function($q) use ($categoryIds) {
                $q->whereIn('categories.id', $categoryIds);
            })
            ->where('is_active', true)
            ->selectRaw('MIN(price) as min, MAX(price) as max')
            ->first();
        
        // Categorii pentru sidebar
        $categories = Category::with(['children' => function($query) {
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
                ->with(['categories', 'colors'])
                ->firstOrFail();
            
            return view('shop.show', compact('product'));
        }

        // Categorie normală
        $category = Category::where('slug', $categorySlug)
            ->where('is_active', true)
            ->firstOrFail();
        
        $product = Product::whereHas('categories', function($query) use ($category) {
                $query->where('categories.id', $category->id);
            })
            ->where('slug', $productSlug)
            ->where('is_active', true)
            ->with(['categories', 'colors'])
            ->firstOrFail();
        
        return view('shop.show', compact('product', 'category'));
    }
}