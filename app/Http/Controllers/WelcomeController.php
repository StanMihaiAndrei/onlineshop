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
        $bijuteriiCategory = Category::where('slug', 'bijuterii')->first();
        $pomisoriCategory = Category::where('slug', 'pomisori')->first();

        // Obține primele 4 produse pentru fiecare categorie
        $decoratiuniCasa = $decoratiuniCasaCategory
            ? Product::whereHas('categories', function ($query) use ($decoratiuniCasaCategory) {
                $query->where('categories.id', $decoratiuniCasaCategory->id);
            })->where('stock', '>', 0)->inRandomOrder()->take(4)->get()
            : collect();

        $bijuterii = $bijuteriiCategory
            ? Product::whereHas('categories', function ($query) use ($bijuteriiCategory) {
                $query->where('categories.id', $bijuteriiCategory->id);
            })->where('stock', '>', 0)->inRandomOrder()->take(4)->get()
            : collect();

        $pomisori = $pomisoriCategory
            ? Product::whereHas('categories', function ($query) use ($pomisoriCategory) {
                $query->where('categories.id', $pomisoriCategory->id);
            })->where('stock', '>', 0)->inRandomOrder()->take(4)->get()
            : collect();

        return view('welcome', compact(
            'decoratiuniCasa',
            'bijuterii',
            'pomisori',
            'decoratiuniCasaCategory',
            'bijuteriiCategory',
            'pomisoriCategory'
        ));
    }
}