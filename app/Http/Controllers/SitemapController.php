<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function index()
    {
        // Folosim is_active în loc de status și includem categories cu eager loading
        $products = Product::where('is_active', true)
            ->with('categories:id,slug')
            ->select('id', 'slug', 'updated_at')
            ->get();
        
        $categories = Category::select('id', 'slug', 'updated_at')
            ->get();

        $content = view('sitemap', [
            'products' => $products,
            'categories' => $categories
        ])->render();

        return response($content, 200)
            ->header('Content-Type', 'text/xml');
    }
}