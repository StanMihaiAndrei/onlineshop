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

        // Filtru după categorie
        if ($request->has('category') && $request->category) {
            $query->whereHas('categories', function($q) use ($request) {
                $q->where('categories.id', $request->category);
            });
        }

        // Filtru după culoare
        if ($request->has('color') && $request->color) {
            $query->whereHas('colors', function($q) use ($request) {
                $q->where('colors.id', $request->color);
            });
        }

        // Filtru search text (fără SKU)
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
        
        $categories = Category::where('is_active', true)
            ->withCount('products')
            ->orderBy('name')
            ->get();
        
        $colors = Color::where('is_active', true)
            ->orderBy('name')
            ->get();

        $selectedCategory = $request->category ? Category::find($request->category) : null;
        $selectedColor = $request->color ? Color::find($request->color) : null;
        
        return view('shop.index', compact('products', 'categories', 'colors', 'selectedCategory', 'selectedColor', 'priceRange'));
    }

    // Listare produse după categorie - /shop/animale
    public function category(Request $request, $categorySlug)
    {
        $category = Category::where('slug', $categorySlug)
            ->where('is_active', true)
            ->firstOrFail();
        
        $query = Product::whereHas('categories', function($q) use ($category) {
                $q->where('categories.id', $category->id);
            })
            ->where('is_active', true)
            ->with(['categories', 'colors']);

        // Filtru după culoare
        if ($request->has('color') && $request->color) {
            $query->whereHas('colors', function($q) use ($request) {
                $q->where('colors.id', $request->color);
            });
        }

        // Filtru search text (fără SKU)
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
        $priceRange = Product::whereHas('categories', function($q) use ($category) {
                $q->where('categories.id', $category->id);
            })
            ->where('is_active', true)
            ->selectRaw('MIN(price) as min, MAX(price) as max')
            ->first();
        
        $categories = Category::where('is_active', true)
            ->withCount('products')
            ->orderBy('name')
            ->get();
        
        $colors = Color::where('is_active', true)
            ->orderBy('name')
            ->get();

        $selectedColor = $request->color ? Color::find($request->color) : null;
        
        return view('shop.category', compact('products', 'category', 'categories', 'colors', 'selectedColor', 'priceRange'));
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