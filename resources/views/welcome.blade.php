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
    <link rel="preconnect" href="https://fonts.cdnfonts.com">
    <link href="https://fonts.cdnfonts.com/css/comic-relief" rel="stylesheet">
    
    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        .hero-gradient {
            background: linear-gradient(135deg, rgba(219, 28, 181, 0.08) 0%, rgba(246, 241, 235, 1) 100%);
        }
        
        .hover-lift {
            transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1), box-shadow 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .hover-lift:hover {
            transform: translateY(-12px) scale(1.02);
            box-shadow: 0 25px 50px -12px rgba(219, 28, 181, 0.25);
        }
        
        .feature-card {
            background: linear-gradient(145deg, rgba(246, 241, 235, 0.95) 0%, rgba(255, 255, 255, 0.95) 100%);
            border: 2px solid rgba(143, 174, 158, 0.2);
        }

        .feature-card:hover {
            background: linear-gradient(145deg, rgba(255, 255, 255, 1) 0%, rgba(246, 241, 235, 1) 100%);
            border-color: rgba(143, 174, 158, 0.4);
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(3deg); }
        }
        
        .float-animation {
            animation: float 6s ease-in-out infinite;
        }

        @keyframes shimmer {
            0% { background-position: -1000px 0; }
            100% { background-position: 1000px 0; }
        }

        .shimmer {
            background: linear-gradient(90deg, transparent, rgba(219, 28, 181, 0.1), transparent);
            background-size: 1000px 100%;
            animation: shimmer 3s infinite;
        }

        .gradient-border {
            position: relative;
            background: linear-gradient(145deg, #f6f1eb, #ffffff);
            padding: 2px;
            border-radius: 1rem;
        }

        .gradient-border-content {
            background: #f6f1eb;
            border-radius: calc(1rem - 2px);
        }

        .testimonial-card {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.9) 0%, rgba(246, 241, 235, 0.9) 100%);
            border: 2px solid rgba(143, 174, 158, 0.15);
            backdrop-filter: blur(10px);
        }

        .pulse-slow {
            animation: pulse 3s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-slide-in {
            animation: slideIn 0.6s ease-out forwards;
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
<body class="antialiased font-sans bg-background text-text">
    <!-- Navigation - folosim componenta existentă -->
    <livewire:layout.navigation />

    <!-- Hero Section -->
    <section class="pt-32 pb-20 hero-gradient relative overflow-hidden">
        <!-- Decorative Elements -->
        <div class="absolute top-20 right-10 w-64 h-64 bg-primary/5 rounded-full blur-3xl"></div>
        <div class="absolute bottom-20 left-10 w-96 h-96 bg-secondary/5 rounded-full blur-3xl"></div>
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid md:grid-cols-2 gap-12 items-center">
                <div class="space-y-6 animate-slide-in">
                    <div class="inline-block">
                        <span class="bg-primary/10 text-primary px-4 py-2 rounded-full text-sm font-semibold border-2 border-primary/20">
                            ✨ Creații 100% Handmade
                        </span>
                    </div>
                    
                    <h1 class="text-5xl md:text-7xl font-bold text-text leading-tight">
                        Descoperă Magia
                        <span class="text-primary relative inline-block">
                            Handmade
                            <svg class="absolute -bottom-2 left-0 w-full" height="12" viewBox="0 0 200 12" fill="none">
                                <path d="M2 10C60 2 140 2 198 10" stroke="#8fae9e" stroke-width="3" stroke-linecap="round"/>
                            </svg>
                        </span>
                    </h1>
                    
                    <p class="text-xl text-text/80 leading-relaxed">
                        Fiecare piesă creată la <strong class="text-primary">Craft Gifts</strong> spune o poveste unică. Bijuterii artizanale, decorațiuni personalizate și cadouri speciale, realizate cu pasiune și atenție la detalii pentru momentele tale importante.
                    </p>
                    
                    <div class="flex flex-wrap gap-4 pt-4">
                        <a href="{{ route('shop') }}" class="group bg-primary text-white px-10 py-5 rounded-full hover:bg-primary-dark transition-all transform hover:scale-105 font-bold text-lg shadow-2xl hover:shadow-primary/50 flex items-center gap-2">
                            Explorează Magazinul
                            <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                            </svg>
                        </a>
                        <a href="#colectii" class="border-3 border-secondary bg-secondary/5 text-text px-10 py-5 rounded-full hover:bg-secondary hover:text-white transition-all font-bold text-lg shadow-lg hover:shadow-secondary/30">
                            Vezi Colecții
                        </a>
                    </div>
                    
                    <!-- Trust Indicators -->
                    <div class="flex flex-wrap gap-6 pt-8">
                        <div class="flex items-center gap-2 bg-white/50 px-4 py-2 rounded-full border-2 border-secondary/20">
                            <svg class="w-6 h-6 text-primary" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                            <span class="text-text font-bold">100% Handmade</span>
                        </div>
                        <div class="flex items-center gap-2 bg-white/50 px-4 py-2 rounded-full border-2 border-secondary/20">
                            <svg class="w-6 h-6 text-primary" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"/>
                            </svg>
                            <span class="text-text font-bold">Calitate Premium</span>
                        </div>
                        <div class="flex items-center gap-2 bg-white/50 px-4 py-2 rounded-full border-2 border-secondary/20">
                            <svg class="w-6 h-6 text-primary" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z"/>
                                <path d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H10a1 1 0 001-1V5a1 1 0 00-1-1H3zM14 7a1 1 0 00-1 1v6.05A2.5 2.5 0 0115.95 16H17a1 1 0 001-1v-5a1 1 0 00-.293-.707l-2-2A1 1 0 0015 7h-1z"/>
                            </svg>
                            <span class="text-text font-bold">Livrare Rapidă</span>
                        </div>
                    </div>
                </div>
                
                <div class="relative" style="animation-delay: 0.2s;" class="animate-slide-in">
                    <div class="float-animation">
                        <div class="gradient-border shadow-2xl">
                            <div class="gradient-border-content aspect-square flex items-center justify-center">
                                <div class="text-center p-8">
                                    <svg class="w-32 h-32 mx-auto text-primary mb-4 pulse-slow" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                    <p class="text-text/60 italic font-semibold">Adaugă imaginea principală aici</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="absolute -top-4 -right-4 w-24 h-24 bg-primary/10 rounded-full blur-2xl animate-pulse"></div>
                    <div class="absolute -bottom-4 -left-4 w-32 h-32 bg-secondary/10 rounded-full blur-2xl animate-pulse" style="animation-delay: 1s;"></div>
                </div>
            </div>

            <!-- Stats Bar -->
            <div class="mt-20 grid grid-cols-2 md:grid-cols-4 gap-6">
                <div class="bg-white/60 backdrop-blur-sm p-6 rounded-2xl border-2 border-secondary/20 text-center hover:scale-105 transition-transform">
                    <div class="text-4xl font-bold text-primary mb-2">500+</div>
                    <div class="text-text/70 font-semibold">Produse Unice</div>
                </div>
                <div class="bg-white/60 backdrop-blur-sm p-6 rounded-2xl border-2 border-secondary/20 text-center hover:scale-105 transition-transform">
                    <div class="text-4xl font-bold text-primary mb-2">2000+</div>
                    <div class="text-text/70 font-semibold">Clienți Fericiți</div>
                </div>
                <div class="bg-white/60 backdrop-blur-sm p-6 rounded-2xl border-2 border-secondary/20 text-center hover:scale-105 transition-transform">
                    <div class="text-4xl font-bold text-primary mb-2">5.0★</div>
                    <div class="text-text/70 font-semibold">Rating Mediu</div>
                </div>
                <div class="bg-white/60 backdrop-blur-sm p-6 rounded-2xl border-2 border-secondary/20 text-center hover:scale-105 transition-transform">
                    <div class="text-4xl font-bold text-primary mb-2">100%</div>
                    <div class="text-text/70 font-semibold">Handmade</div>
                </div>
            </div>
        </div>
    </section>

   <!-- Collections Preview -->
<section id="colectii" class="py-20 bg-white relative overflow-hidden">
    <div class="absolute top-0 left-0 w-full h-full opacity-5">
        <div class="absolute top-20 right-20 w-64 h-64 bg-secondary rounded-full blur-3xl"></div>
        <div class="absolute bottom-20 left-20 w-64 h-64 bg-primary rounded-full blur-3xl"></div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="text-center mb-12">
            <h2 class="text-5xl font-bold text-text mb-4">Produsele Noastre</h2>
            <div class="w-24 h-1 bg-gradient-to-r from-primary to-secondary mx-auto mb-6 rounded-full"></div>
            <p class="text-xl text-text/70 max-w-3xl mx-auto">
                Explorează universul creațiilor handmade, de la bijuterii elegante la decorațiuni de casă și cadouri personalizate pentru orice ocazie specială.
            </p>
        </div>
        
        <div x-data="{ activeTab: 'decoratiuni' }">
            <!-- Category Tabs -->
            <div class="flex justify-center mb-8">
                <div class="inline-flex rounded-2xl bg-background shadow-xl p-2 border-3 border-secondary/20">
                    <button @click="activeTab = 'decoratiuni'" 
                            :class="activeTab === 'decoratiuni' ? 'bg-primary text-white shadow-lg scale-105' : 'text-text hover:text-primary hover:bg-white/50'"
                            class="px-8 py-3 rounded-xl font-bold text-sm transition-all">
                        Decorațiuni Casă
                    </button>
                    <button @click="activeTab = 'bijuterii'" 
                            :class="activeTab === 'bijuterii' ? 'bg-primary text-white shadow-lg scale-105' : 'text-text hover:text-primary hover:bg-white/50'"
                            class="px-8 py-3 rounded-xl font-bold text-sm transition-all">
                        Bijuterii
                    </button>
                    <button @click="activeTab = 'pomisori'" 
                            :class="activeTab === 'pomisori' ? 'bg-primary text-white shadow-lg scale-105' : 'text-text hover:text-primary hover:bg-white/50'"
                            class="px-8 py-3 rounded-xl font-bold text-sm transition-all">
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
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                        @foreach($decoratiuniCasa as $product)
                            <x-product-card :product="$product" />
                        @endforeach
                    </div>
                    
                    <div class="text-center mt-10">
                        <a href="{{ route('shop') }}" 
                           class="group inline-flex items-center gap-2 bg-gradient-to-r from-primary to-primary-dark text-white px-10 py-4 rounded-full transition-all transform hover:scale-105 font-bold shadow-2xl hover:shadow-primary/50">
                            Vezi toate produsele
                            <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                            </svg>
                        </a>
                    </div>
                @else
                    <div class="text-center py-12 bg-background rounded-xl shadow-md border-2 border-secondary/20">
                        <p class="text-text/60 text-lg font-semibold">Nu există produse în această categorie momentan.</p>
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
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                        @foreach($bijuterii as $product)
                            <x-product-card :product="$product" />
                        @endforeach
                    </div>
                    
                    <div class="text-center mt-10">
                        <a href="{{ route('shop') }}" 
                           class="group inline-flex items-center gap-2 bg-gradient-to-r from-primary to-primary-dark text-white px-10 py-4 rounded-full transition-all transform hover:scale-105 font-bold shadow-2xl hover:shadow-primary/50">
                            Vezi toate produsele
                            <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                            </svg>
                        </a>
                    </div>
                @else
                    <div class="text-center py-12 bg-background rounded-xl shadow-md border-2 border-secondary/20">
                        <p class="text-text/60 text-lg font-semibold">Nu există produse în această categorie momentan.</p>
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
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                        @foreach($pomisori as $product)
                            <x-product-card :product="$product" />
                        @endforeach
                    </div>
                    
                    <div class="text-center mt-10">
                        <a href="{{ route('shop') }}" 
                           class="group inline-flex items-center gap-2 bg-gradient-to-r from-primary to-primary-dark text-white px-10 py-4 rounded-full transition-all transform hover:scale-105 font-bold shadow-2xl hover:shadow-primary/50">
                            Vezi toate produsele
                            <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                            </svg>
                        </a>
                    </div>
                @else
                    <div class="text-center py-12 bg-background rounded-xl shadow-md border-2 border-secondary/20">
                        <p class="text-text/60 text-lg font-semibold">Nu există produse în această categorie momentan.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>

    <!-- Features Section -->
    <section class="py-20 bg-gradient-to-b from-white to-background">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-5xl font-bold text-text mb-4">De Ce Craft Gifts?</h2>
                <div class="w-24 h-1 bg-gradient-to-r from-primary to-secondary mx-auto mb-6 rounded-full"></div>
                <p class="text-xl text-text/70 max-w-3xl mx-auto">
                    Fiecare creație este rezultatul unui proces artizanal dedicat, unde pasiunea pentru detalii și creativitatea se îmbină pentru a oferi produse unice și memorabile.
                </p>
            </div>
            
            <div class="grid md:grid-cols-3 gap-8">
                <div class="feature-card p-8 rounded-3xl hover-lift">
                    <div class="w-20 h-20 bg-gradient-to-br from-primary to-primary-dark rounded-2xl flex items-center justify-center mb-6 shadow-xl">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"/>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-text mb-4">Personalizare Completă</h3>
                    <p class="text-text/70 leading-relaxed">
                        Transformăm ideile tale în realitate. Fiecare comandă poate fi personalizată după preferințele tale, asigurându-ne că primești exact ceea ce îți dorești pentru a face cadoul perfect sau pentru a-ți împodobi spațiul tău special.
                    </p>
                </div>
                
                <div class="feature-card p-8 rounded-3xl hover-lift">
                    <div class="w-20 h-20 bg-gradient-to-br from-secondary to-primary rounded-2xl flex items-center justify-center mb-6 shadow-xl">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-text mb-4">Materiale Premium</h3>
                    <p class="text-text/70 leading-relaxed">
                        Selectăm cu atenție cele mai bune materiale pentru fiecare creație. De la margele cristal până la lemn natural și metale nobile, garantăm durabilitate și frumusețe de lungă durată pentru fiecare piesă handmade.
                    </p>
                </div>
                
                <div class="feature-card p-8 rounded-3xl hover-lift">
                    <div class="w-20 h-20 bg-gradient-to-br from-primary-dark to-secondary rounded-2xl flex items-center justify-center mb-6 shadow-xl">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-text mb-4">Creat cu Pasiune</h3>
                    <p class="text-text/70 leading-relaxed">
                        În spatele fiecărei bijuterii și decorațiuni stă o poveste de dedicare și creativitate. Lucrăm cu dragoste la fiecare detaliu pentru a crea piese unice care să aducă bucurie și să marcheze momentele tale speciale.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="py-20 bg-white relative overflow-hidden">
        <div class="absolute inset-0 opacity-5">
            <div class="absolute top-10 left-10 w-72 h-72 bg-primary rounded-full blur-3xl"></div>
            <div class="absolute bottom-10 right-10 w-72 h-72 bg-secondary rounded-full blur-3xl"></div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="text-center mb-16">
                <h2 class="text-5xl font-bold text-text mb-4">Ce Spun Clienții Noștri</h2>
                <div class="w-24 h-1 bg-gradient-to-r from-primary to-secondary mx-auto mb-6 rounded-full"></div>
                <p class="text-xl text-text/70 max-w-3xl mx-auto">
                    Feedback-ul autentic al clienților mulțumiți care au descoperit magia creațiilor noastre handmade.
                </p>
            </div>

            <!-- Testimonials Grid -->
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6 mb-10">
                @foreach($testimonials as $testimonial)
                <div class="testimonial-card p-6 rounded-2xl hover-lift group">
                    <!-- Stars -->
                    <div class="flex gap-1 mb-4">
                        @for($i = 0; $i < $testimonial['rating']; $i++)
                        <svg class="w-5 h-5 text-primary" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                        @endfor
                    </div>

                    <!-- Review Text -->
                    <p class="text-text/80 leading-relaxed mb-6 italic">
                        "{{ $testimonial['text'] }}"
                    </p>

                    <!-- Author Info -->
                    <div class="flex items-center justify-between pt-4 border-t-2 border-secondary/20">
                        <div>
                            <div class="font-bold text-text">{{ $testimonial['name'] }}</div>
                            <div class="text-sm text-text/60 flex items-center gap-1">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z"/>
                                </svg>
                                {{ $testimonial['location'] }}
                            </div>
                        </div>
                        <div class="text-xs text-text/50">{{ $testimonial['date'] }}</div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Trust Badge -->
            <div class="bg-gradient-to-r from-primary/5 to-secondary/5 rounded-3xl p-8 text-center border-2 border-secondary/20">
                <div class="flex items-center justify-center gap-2 mb-3">
                    <div class="flex">
                        @for($i = 0; $i < 5; $i++)
                        <svg class="w-8 h-8 text-primary" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                        @endfor
                    </div>
                    <span class="text-3xl font-bold text-text">5.0</span>
                </div>
                <p class="text-text/70 text-lg">
                    <strong class="text-primary">150+ recenzii</strong> de la clienți mulțumiți care recomandă produsele noastre
                </p>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="despre" class="py-20 bg-background">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-2 gap-12 items-center">
                <div>
                    <h2 class="text-5xl font-bold text-text mb-6">Povestea Noastră</h2>
                    <div class="w-24 h-1 bg-gradient-to-r from-primary to-secondary mb-8 rounded-full"></div>
                    <div class="space-y-4 text-text/80 leading-relaxed text-lg">
                        <p>
                            <strong class="text-primary font-bold">Craft Gifts</strong> este mai mult decât un magazin online - este o comunitate de pasionați de artă handmade și frumusețe autentică. Am început această călătorie din dorința de a crea piese unice care să aducă bucurie și să celebreze momentele speciale ale vieții.
                        </p>
                        <p>
                            Fiecare bijuterie, fiecare decorațiune și fiecare cadou personalizat este creat cu atenție la detalii și dragoste pentru meșteșug. Folosim doar materiale de calitate superioară și tehnici artizanale tradiționale, combinate cu design modern și inovator.
                        </p>
                        <p>
                            Credem că fiecare persoană merită să aibă acces la produse unice și personalizate care reflectă personalitatea și stilul lor. De aceea, oferim opțiuni complete de personalizare și un serviciu dedicat pentru fiecare client.
                        </p>
                        <p>
                            Fie că cauți un cadou special pentru o persoană dragă, bijuterii elegante pentru o ocazie importantă sau decorațiuni pentru a-ți transforma casa într-un spațiu unic, la <strong class="text-primary font-bold">Craft Gifts</strong> vei găsi piese create cu pasiune și devotament.
                        </p>
                    </div>
                    <div class="mt-8">
                        <a href="{{ route('shop') }}" class="group inline-flex items-center bg-gradient-to-r from-primary to-primary-dark text-white px-10 py-4 rounded-full hover:scale-105 transition-all font-bold text-lg shadow-2xl hover:shadow-primary/50">
                            Descoperă Produsele Noastre
                            <svg class="ml-2 w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                            </svg>
                        </a>
                    </div>
                </div>
                <div class="relative">
                    <div class="gradient-border shadow-2xl">
                        <div class="gradient-border-content aspect-square flex items-center justify-center">
                            <div class="text-center p-8">
                                <svg class="w-32 h-32 mx-auto text-primary mb-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                                <p class="text-text/60 italic font-semibold">Adaugă imagine aici<br>(proces de lucru / atelier)</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20 bg-gradient-to-br from-primary/10 via-background to-secondary/10 relative overflow-hidden">
        <div class="absolute inset-0">
            <div class="absolute top-0 left-1/4 w-96 h-96 bg-primary/10 rounded-full blur-3xl"></div>
            <div class="absolute bottom-0 right-1/4 w-96 h-96 bg-secondary/10 rounded-full blur-3xl"></div>
        </div>

        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
            <h2 class="text-4xl md:text-6xl font-bold text-text mb-6 leading-tight">
                Gata să Descoperi Ceva Unic?
            </h2>
            <p class="text-xl text-text/70 mb-8 max-w-2xl mx-auto">
                Alătură-te comunității noastre și primește acces exclusiv la colecții noi, oferte speciale și inspirație creativă direct în inbox-ul tău.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                <a href="{{ route('shop') }}" class="group bg-gradient-to-r from-primary to-primary-dark text-white px-12 py-5 rounded-full hover:scale-105 transition-all transform font-bold text-lg shadow-2xl hover:shadow-primary/50 flex items-center gap-2">
                    Începe Cumpărăturile
                    <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                    </svg>
                </a>
                <a href="{{ route('register') }}" class="border-3 border-secondary bg-secondary/10 text-text px-12 py-5 rounded-full hover:bg-secondary hover:text-white transition-all font-bold text-lg shadow-lg hover:shadow-secondary/30">
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