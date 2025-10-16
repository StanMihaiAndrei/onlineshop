<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index()
    {
        $products = Product::where('is_active', true)
            ->latest()
            ->paginate(12);
        
        return view('shop.index', compact('products'));
    }

    public function show($slug)
    {
        $product = Product::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();
        
        return view('shop.show', compact('product'));
    }
}