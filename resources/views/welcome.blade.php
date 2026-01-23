{{-- filepath: c:\Apache24\htdocs\onlineshop\resources\views\welcome.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <!-- SEO Meta Tags -->
    <title>Craft Gifts - Decorațiuni Handmade Unice | Bijuterii & Cadouri Personalizate</title>
    <meta name="description" content="Descoperă lumea magică a decorațiunilor handmade de la Craft Gifts. Bijuterii unice, cadouri personalizate și decorațiuni artizanale create cu pasiune. Comandă online și oferă cadouri speciale!">
    <meta name="keywords" content="decoratiuni handmade, bijuterii artizanale, cadouri personalizate, craft Romania, decoratiuni unicat, cadouri unice, handmade Romania">
    <meta name="author" content="Craft Gifts">
    <meta name="robots" content="index, follow">
    
    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://craftgifts.ro/">
    <meta property="og:title" content="Craft Gifts - Decorațiuni Handmade Unice">
    <meta property="og:description" content="Bijuterii artizanale, decorațiuni și cadouri personalizate create cu pasiune. Fiecare piesă este unică!">
    <meta property="og:image" content="{{ asset('images/og-image.jpg') }}">
    
    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="https://craftgifts.ro/">
    <meta property="twitter:title" content="Craft Gifts - Decorațiuni Handmade Unice">
    <meta property="twitter:description" content="Bijuterii artizanale, decorațiuni și cadouri personalizate create cu pasiune.">
    
    <!-- Canonical URL -->
    <link rel="canonical" href="https://craftgifts.ro/">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=playfair-display:400,600,700|inter:400,500,600&display=swap" rel="stylesheet" />
    
    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        :root {
            --primary: rgb(219, 28, 181);
            --primary-dark: rgb(180, 20, 145);
            --gray: rgb(107, 114, 128);
            --gray-light: rgb(243, 244, 246);
        }
        
        .font-playfair { font-family: 'Playfair Display', serif; }
        .text-primary { color: var(--primary); }
        .bg-primary { background-color: var(--primary); }
        .border-primary { border-color: var(--primary); }
        .hover\:bg-primary-dark:hover { background-color: var(--primary-dark); }
        
        .hero-gradient {
            background: linear-gradient(135deg, rgba(219, 28, 181, 0.1) 0%, rgba(255, 255, 255, 1) 100%);
        }
        
        .hover-lift {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .hover-lift:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(219, 28, 181, 0.2);
        }
        
        .feature-card {
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.9);
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }
        
        .float-animation {
            animation: float 6s ease-in-out infinite;
        }
    </style>
    
    <!-- Schema.org Structured Data -->
    <script type="application/ld+json">
    {
        "context": "https://schema.org",
        "type": "Store",
        "name": "Craft Gifts",
        "description": "Magazin online cu decorațiuni handmade, bijuterii artizanale și cadouri personalizate",
        "url": "https://craftgifts.ro",
        "logo": "https://craftgifts.ro/images/transparent.png",
        "image": "https://craftgifts.ro/images/og-image.jpg",
        "priceRange": "$$",
        "address": {
            "@type": "PostalAddress",
            "addressCountry": "RO"
        },
        "sameAs": [
            "https://www.facebook.com/craftgifts",
            "https://www.instagram.com/craftgifts"
        ]
    }
    </script>
</head>
<body class="antialiased font-sans">
    <!-- Navigation - folosim componenta existentă -->
    <livewire:layout.navigation />

    <!-- Hero Section -->
    <section class="pt-32 pb-20 hero-gradient">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-2 gap-12 items-center">
                <div class="space-y-6">
                    <h1 class="text-5xl md:text-6xl font-playfair font-bold text-gray-900 leading-tight">
                        Descoperă Magia
                        <span class="text-primary">Handmade</span>
                    </h1>
                    <p class="text-xl text-gray-600 leading-relaxed">
                        Fiecare piesă creată la <strong>Craft Gifts</strong> spune o poveste unică. Bijuterii artizanale, decorațiuni personalizate și cadouri speciale, realizate cu pasiune și atenție la detalii pentru momentele tale importante.
                    </p>
                    <div class="flex flex-wrap gap-4">
                        <a href="{{ route('shop') }}" class="bg-primary text-white px-8 py-4 rounded-full hover:bg-primary-dark transition-all transform hover:scale-105 font-semibold text-lg shadow-lg">
                            Explorează Magazinul
                        </a>
                        <a href="#colectii" class="border-2 border-primary text-primary px-8 py-4 rounded-full hover:bg-primary hover:text-white transition-all font-semibold text-lg">
                            Vezi Colecții
                        </a>
                    </div>
                    
                    <!-- Trust Indicators -->
                    <div class="flex flex-wrap gap-6 pt-6">
                        <div class="flex items-center gap-2">
                            <svg class="w-6 h-6 text-primary" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                            <span class="text-gray-700 font-medium">100% Handmade</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <svg class="w-6 h-6 text-primary" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"/>
                            </svg>
                            <span class="text-gray-700 font-medium">Calitate Premium</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <svg class="w-6 h-6 text-primary" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z"/>
                                <path d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H10a1 1 0 001-1V5a1 1 0 00-1-1H3zM14 7a1 1 0 00-1 1v6.05A2.5 2.5 0 0115.95 16H17a1 1 0 001-1v-5a1 1 0 00-.293-.707l-2-2A1 1 0 0015 7h-1z"/>
                            </svg>
                            <span class="text-gray-700 font-medium">Livrare Rapidă</span>
                        </div>
                    </div>
                </div>
                
                <div class="relative">
                    <div class="float-animation">
                        <div class="bg-gradient-to-br from-pink-100 to-purple-100 rounded-3xl aspect-square flex items-center justify-center shadow-2xl">
                            <div class="text-center p-8">
                                <svg class="w-32 h-32 mx-auto text-primary mb-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                                <p class="text-gray-600 italic">Adaugă imaginea principală aici</p>
                            </div>
                        </div>
                    </div>
                    <div class="absolute -top-4 -right-4 w-24 h-24 bg-primary/20 rounded-full blur-xl"></div>
                    <div class="absolute -bottom-4 -left-4 w-32 h-32 bg-purple-300/20 rounded-full blur-xl"></div>
                </div>
            </div>
        </div>
    </section>

   <!-- Collections Preview -->
<section id="colectii" class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-4xl font-playfair font-bold text-gray-900 mb-4">Colecțiile Noastre</h2>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                Explorează universul creațiilor handmade, de la bijuterii elegante la decorațiuni de casă și cadouri personalizate pentru orice ocazie specială.
            </p>
        </div>
        
        <div x-data="{ activeTab: 'decoratiuni' }">
            <!-- Category Tabs -->
            <div class="flex justify-center mb-8">
                <div class="inline-flex rounded-xl bg-white shadow-md p-1.5 border border-gray-200">
                    <button @click="activeTab = 'decoratiuni'" 
                            :class="activeTab === 'decoratiuni' ? 'bg-primary text-white' : 'text-gray-600 hover:text-gray-900'"
                            class="px-6 py-2.5 rounded-lg font-semibold text-sm transition-all">
                        Decorațiuni Casă
                    </button>
                    <button @click="activeTab = 'bijuterii'" 
                            :class="activeTab === 'bijuterii' ? 'bg-primary text-white' : 'text-gray-600 hover:text-gray-900'"
                            class="px-6 py-2.5 rounded-lg font-semibold text-sm transition-all">
                        Bijuterii
                    </button>
                    <button @click="activeTab = 'pomisori'" 
                            :class="activeTab === 'pomisori' ? 'bg-primary text-white' : 'text-gray-600 hover:text-gray-900'"
                            class="px-6 py-2.5 rounded-lg font-semibold text-sm transition-all">
                        Pomișori
                    </button>
                </div>
            </div>

            <!-- Products Grid - Decorațiuni Casă -->
            <div x-show="activeTab === 'decoratiuni'" 
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 transform scale-95"
                 x-transition:enter-end="opacity-100 transform scale-100">
                @if($decoratiuniCasa->count() > 0)
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                        @foreach($decoratiuniCasa as $product)
                            <x-product-card :product="$product" />
                        @endforeach
                    </div>
                    
                    <div class="text-center mt-8">
                        <a href="{{ route('shop') }}" 
                           class="inline-flex items-center gap-2 bg-primary hover:bg-primary-dark text-white px-8 py-3 rounded-full transition-all transform hover:scale-105 font-semibold shadow-lg">
                            Vezi toate produsele
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                            </svg>
                        </a>
                    </div>
                @else
                    <div class="text-center py-12 bg-white rounded-xl shadow-md">
                        <p class="text-gray-500 text-lg">Nu există produse în această categorie momentan.</p>
                    </div>
                @endif
            </div>

            <!-- Products Grid - Bijuterii -->
            <div x-show="activeTab === 'bijuterii'" 
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 transform scale-95"
                 x-transition:enter-end="opacity-100 transform scale-100"
                 style="display: none;">
                @if($bijuterii->count() > 0)
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                        @foreach($bijuterii as $product)
                            <x-product-card :product="$product" />
                        @endforeach
                    </div>
                    
                    <div class="text-center mt-8">
                        <a href="{{ route('shop') }}" 
                           class="inline-flex items-center gap-2 bg-primary hover:bg-primary-dark text-white px-8 py-3 rounded-full transition-all transform hover:scale-105 font-semibold shadow-lg">
                            Vezi toate produsele
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                            </svg>
                        </a>
                    </div>
                @else
                    <div class="text-center py-12 bg-white rounded-xl shadow-md">
                        <p class="text-gray-500 text-lg">Nu există produse în această categorie momentan.</p>
                    </div>
                @endif
            </div>

            <!-- Products Grid - Pomișori -->
            <div x-show="activeTab === 'pomisori'" 
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 transform scale-95"
                 x-transition:enter-end="opacity-100 transform scale-100"
                 style="display: none;">
                @if($pomisori->count() > 0)
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                        @foreach($pomisori as $product)
                            <x-product-card :product="$product" />
                        @endforeach
                    </div>
                    
                    <div class="text-center mt-8">
                        <a href="{{ route('shop') }}" 
                           class="inline-flex items-center gap-2 bg-primary hover:bg-primary-dark text-white px-8 py-3 rounded-full transition-all transform hover:scale-105 font-semibold shadow-lg">
                            Vezi toate produsele
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                            </svg>
                        </a>
                    </div>
                @else
                    <div class="text-center py-12 bg-white rounded-xl shadow-md">
                        <p class="text-gray-500 text-lg">Nu există produse în această categorie momentan.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>

    <!-- Features Section -->
    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-playfair font-bold text-gray-900 mb-4">De Ce Craft Gifts?</h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    Fiecare creație este rezultatul unui proces artizanal dedicat, unde pasiunea pentru detalii și creativitatea se îmbină pentru a oferi produse unice și memorabile.
                </p>
            </div>
            
            <div class="grid md:grid-cols-3 gap-8">
                <div class="feature-card p-8 rounded-2xl border border-gray-200 hover-lift">
                    <div class="w-16 h-16 bg-primary/10 rounded-full flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"/>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-playfair font-bold text-gray-900 mb-4">Personalizare Completă</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Transformăm ideile tale în realitate. Fiecare comandă poate fi personalizată după preferințele tale, asigurându-ne că primești exact ceea ce îți dorești pentru a face cadoul perfect sau pentru a-ți împodobi spațiul tău special.
                    </p>
                </div>
                
                <div class="feature-card p-8 rounded-2xl border border-gray-200 hover-lift">
                    <div class="w-16 h-16 bg-primary/10 rounded-full flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-playfair font-bold text-gray-900 mb-4">Materiale Premium</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Selectăm cu atenție cele mai bune materiale pentru fiecare creație. De la margele cristal până la lemn natural și metale nobile, garantăm durabilitate și frumusețe de lungă durată pentru fiecare piesă handmade.
                    </p>
                </div>
                
                <div class="feature-card p-8 rounded-2xl border border-gray-200 hover-lift">
                    <div class="w-16 h-16 bg-primary/10 rounded-full flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-playfair font-bold text-gray-900 mb-4">Creat cu Pasiune</h3>
                    <p class="text-gray-600 leading-relaxed">
                        În spatele fiecărei bijuterii și decorațiuni stă o poveste de dedicare și creativitate. Lucrăm cu dragoste la fiecare detaliu pentru a crea piese unice care să aducă bucurie și să marcheze momentele tale speciale.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Collections Preview -->
    {{-- <section id="colectii" class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-playfair font-bold text-gray-900 mb-4">Colecțiile Noastre</h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    Explorează universul creațiilor handmade, de la bijuterii elegante la decorațiuni de casă și cadouri personalizate pentru orice ocazie specială.
                </p>
            </div>
            
            <div class="grid md:grid-cols-3 gap-8">
                <a href="{{ route('shop') }}" class="group">
                    <div class="bg-white rounded-2xl overflow-hidden shadow-lg hover-lift">
                        <div class="aspect-square bg-gradient-to-br from-pink-100 to-purple-100 flex items-center justify-center">
                            <svg class="w-24 h-24 text-primary group-hover:scale-110 transition-transform" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5 2a1 1 0 011 1v1h1a1 1 0 010 2H6v1a1 1 0 01-2 0V6H3a1 1 0 010-2h1V3a1 1 0 011-1zm0 10a1 1 0 011 1v1h1a1 1 0 110 2H6v1a1 1 0 11-2 0v-1H3a1 1 0 110-2h1v-1a1 1 0 011-1zM12 2a1 1 0 01.967.744L14.146 7.2 17.5 9.134a1 1 0 010 1.732l-3.354 1.935-1.18 4.455a1 1 0 01-1.933 0L9.854 12.8 6.5 10.866a1 1 0 010-1.732l3.354-1.935 1.18-4.455A1 1 0 0112 2z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div class="p-6">
                            <h3 class="text-2xl font-playfair font-bold text-gray-900 mb-2">Bijuterii Artizanale</h3>
                            <p class="text-gray-600 mb-4">Coliere, brățări și cercei unici, realizate manual cu materiale de calitate superioară.</p>
                            <span class="text-primary font-semibold group-hover:underline">Explorează colecția →</span>
                        </div>
                    </div>
                </a>
                
                <a href="{{ route('shop') }}" class="group">
                    <div class="bg-white rounded-2xl overflow-hidden shadow-lg hover-lift">
                        <div class="aspect-square bg-gradient-to-br from-purple-100 to-blue-100 flex items-center justify-center">
                            <svg class="w-24 h-24 text-primary group-hover:scale-110 transition-transform" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/>
                            </svg>
                        </div>
                        <div class="p-6">
                            <h3 class="text-2xl font-playfair font-bold text-gray-900 mb-2">Decorațiuni Casa</h3>
                            <p class="text-gray-600 mb-4">Transformă-ți spațiul cu decorațiuni handmade ce aduc căldură și personalitate.</p>
                            <span class="text-primary font-semibold group-hover:underline">Explorează colecția →</span>
                        </div>
                    </div>
                </a>
                
                <a href="{{ route('shop') }}" class="group">
                    <div class="bg-white rounded-2xl overflow-hidden shadow-lg hover-lift">
                        <div class="aspect-square bg-gradient-to-br from-blue-100 to-pink-100 flex items-center justify-center">
                            <svg class="w-24 h-24 text-primary group-hover:scale-110 transition-transform" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5 5a3 3 0 015-2.236A3 3 0 0114.83 6H16a2 2 0 110 4h-5V9a1 1 0 10-2 0v1H4a2 2 0 110-4h1.17C5.06 5.687 5 5.35 5 5zm4 1V5a1 1 0 10-1 1h1zm3 0a1 1 0 10-1-1v1h1z" clip-rule="evenodd"/>
                                <path d="M9 11H3v5a2 2 0 002 2h4v-7zM11 18h4a2 2 0 002-2v-5h-6v7z"/>
                            </svg>
                        </div>
                        <div class="p-6">
                            <h3 class="text-2xl font-playfair font-bold text-gray-900 mb-2">Cadouri Personalizate</h3>
                            <p class="text-gray-600 mb-4">Cadouri memorabile pentru zile de naștere, nunți, botezuri și alte evenimente speciale.</p>
                            <span class="text-primary font-semibold group-hover:underline">Explorează colecția →</span>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </section> --}}

    <!-- About Section -->
    <section id="despre" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-2 gap-12 items-center">
                <div>
                    <h2 class="text-4xl font-playfair font-bold text-gray-900 mb-6">Povestea Noastră</h2>
                    <div class="space-y-4 text-gray-600 leading-relaxed">
                        <p>
                            <strong>Craft Gifts</strong> este mai mult decât un magazin online - este o comunitate de pasionați de artă handmade și frumusețe autentică. Am început această călătorie din dorința de a crea piese unice care să aducă bucurie și să celebreze momentele speciale ale vieții.
                        </p>
                        <p>
                            Fiecare bijuterie, fiecare decorațiune și fiecare cadou personalizat este creat cu atenție la detalii și dragoste pentru meșteșug. Folosim doar materiale de calitate superioară și tehnici artizanale tradiționale, combinate cu design modern și inovator.
                        </p>
                        <p>
                            Credem că fiecare persoană merită să aibă acces la produse unice și personalizate care reflectă personalitatea și stilul lor. De aceea, oferim opțiuni complete de personalizare și un serviciu dedicat pentru fiecare client.
                        </p>
                        <p>
                            Fie că cauți un cadou special pentru o persoană dragă, bijuterii elegante pentru o ocazie importantă sau decorațiuni pentru a-ți transforma casa într-un spațiu unic, la <strong>Craft Gifts</strong> vei găsi piese create cu pasiune și devotament.
                        </p>
                    </div>
                    <div class="mt-8">
                        <a href="{{ route('shop') }}" class="inline-flex items-center bg-primary text-white px-8 py-4 rounded-full hover:bg-primary-dark transition-all font-semibold text-lg shadow-lg">
                            Descoperă Produsele Noastre
                            <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                            </svg>
                        </a>
                    </div>
                </div>
                <div class="relative">
                    <div class="bg-gradient-to-br from-pink-100 to-purple-100 rounded-3xl aspect-square flex items-center justify-center shadow-2xl">
                        <div class="text-center p-8">
                            <svg class="w-32 h-32 mx-auto text-primary mb-4" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                            <p class="text-gray-600 italic">Adaugă imagine aici<br>(proces de lucru / atelier)</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20 bg-gradient-to-r from-pink-50 to-purple-50">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-4xl md:text-5xl font-playfair font-bold text-gray-900 mb-6">
                Gata să Descoperi Ceva Unic?
            </h2>
            <p class="text-xl text-gray-600 mb-8 max-w-2xl mx-auto">
                Alătură-te comunității noastre și primește acces exclusiv la colecții noi, oferte speciale și inspirație creativă direct în inbox-ul tău.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                <a href="{{ route('shop') }}" class="bg-primary text-white px-10 py-4 rounded-full hover:bg-primary-dark transition-all transform hover:scale-105 font-semibold text-lg shadow-xl">
                    Începe Cumpărăturile
                </a>
                <a href="{{ route('register') }}" class="border-2 border-primary text-primary px-10 py-4 rounded-full hover:bg-primary hover:text-white transition-all font-semibold text-lg">
                    Creează Cont Gratuit
                </a>
            </div>
        </div>
    </section>

    <!-- Footer Component -->
    <livewire:layout.footer />

    <script>

        // Funcții pentru cart și wishlist
        function addToCart(productId, quantity) {
            Livewire.dispatch('cart-add-item', { productId: productId, quantity: quantity });
        }

        function toggleWishlist(productId) {
            Livewire.dispatch('wishlist-toggle', { productId: productId });
        }

        // Listen for wishlist updates from Livewire
        document.addEventListener('livewire:init', () => {
            Livewire.on('wishlist-icon-updated', () => {
                // Refresh page data to sync wishlist state
                setTimeout(() => {
                    window.location.reload();
                }, 300);
            });
        });
        
        // Smooth scroll pentru link-uri anchor
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            });
        });
    </script>
</body>
</html>