<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function index()
    {
        // Obține categoriile
        $decoratiuniCasaCategory = Category::where('slug', 'decoratiuni-casa')->first();
        $cerceiCategory = Category::where('slug', 'cercei')->first();
        $pomisoriCategory = Category::where('slug', 'pomisori')->first();

        // Obține produse pentru fiecare categorie
        $decoratiuniCasa = $decoratiuniCasaCategory 
            ? Product::whereHas('categories', function($query) use ($decoratiuniCasaCategory) {
                $query->where('categories.id', $decoratiuniCasaCategory->id);
            })->where('stock', '>', 0)->inRandomOrder()->take(3)->get()
            : collect();

        $cercei = $cerceiCategory
            ? Product::whereHas('categories', function($query) use ($cerceiCategory) {
                $query->where('categories.id', $cerceiCategory->id);
            })->where('stock', '>', 0)->inRandomOrder()->take(3)->get()
            : collect();

        $pomisori = $pomisoriCategory
            ? Product::whereHas('categories', function($query) use ($pomisoriCategory) {
                $query->where('categories.id', $pomisoriCategory->id);
            })->where('stock', '>', 0)->inRandomOrder()->take(3)->get()
            : collect();

        return view('welcome', compact(
            'decoratiuniCasa', 'cercei', 'pomisori',
            'decoratiuniCasaCategory', 'cerceiCategory', 'pomisoriCategory'
        ));
    }
}