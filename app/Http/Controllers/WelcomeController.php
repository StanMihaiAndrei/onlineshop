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

        // Testimoniale statice
        $testimonials = [
            [
                'name' => 'Maria Popescu',
                'location' => 'București',
                'rating' => 5,
                'text' => 'Am comandat o brățară personalizată pentru mama mea și a fost mai frumoasă decât în poze! Calitatea este excepțională și ambalajul foarte elegant. Recomand cu încredere!',
                'date' => '2 săptămâni în urmă'
            ],
            [
                'name' => 'Andrei Ionescu',
                'location' => 'București',
                'rating' => 5,
                'text' => 'Prima dată când comand produse handmade online și sunt impresionat! Livrare rapidă, comunicare excelentă și produsul exact ca în descriere. Mulțumesc!',
                'date' => '1 lună în urmă'
            ],
            [
                'name' => 'Elena Dumitrescu',
                'location' => 'București',
                'rating' => 5,
                'text' => 'Decorațiunile pentru casă sunt absolut minunate! Se vede că sunt făcute cu dragoste și atenție la detalii. Am primit multe complimente de la oaspeți!',
                'date' => '3 săptămâni în urmă'
            ],
            [
                'name' => 'Cristina Popa',
                'location' => 'Iași',
                'rating' => 5,
                'text' => 'Cadoul perfect pentru nunta prietenei mele! Personalizarea a fost impecabilă și ambalajul de lux. Cu siguranță voi mai comanda!',
                'date' => '1 săptămână în urmă'
            ],
            [
                'name' => 'Mihai Stanciu',
                'location' => 'Brașov',
                'rating' => 5,
                'text' => 'Calitate premium și preț corect. Am fost plăcut surprins de rapiditatea livrării și de frumusețea produsului. Recomand din toată inima!',
                'date' => '2 luni în urmă'
            ],
            [
                'name' => 'Ana Gheorghe',
                'location' => 'Constanța',
                'rating' => 5,
                'text' => 'Bijuteriile sunt unice și foarte elegante. Am primit numeroase complimente când le-am purtat. Serviciul clienți este de nota 10!',
                'date' => '3 săptămâni în urmă'
            ]
        ];

        return view('welcome', compact(
            'decoratiuniCasa',
            'bijuterii',
            'pomisori',
            'decoratiuniCasaCategory',
            'bijuteriiCategory',
            'pomisoriCategory',
            'testimonials'
        ));
    }
}