<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <!-- SEO Meta Tags -->
    <title>Contact - Craft Gifts | Ia Legătura cu Noi</title>
    <meta name="description" content="Contactează-ne pentru întrebări despre produsele handmade, comenzi personalizate sau orice alte informații. Echipa Craft Gifts este aici pentru tine!">
    <meta name="keywords" content="contact craft gifts, contacteaza-ne, intrebari produse handmade, comenzi personalizate, suport clienti, email craft gifts">
    <meta name="author" content="Craft Gifts">
    <meta name="robots" content="index, follow">
    
    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ route('contact') }}">
    <meta property="og:title" content="Contact - Craft Gifts | Ia Legătura cu Noi">
    <meta property="og:description" content="Contactează-ne pentru întrebări despre produsele handmade, comenzi personalizate sau orice alte informații. Echipa Craft Gifts este aici pentru tine!">
    <meta property="og:image" content="{{ asset('images/transparent.jpg') }}">
    
    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ route('contact') }}">
    <meta property="twitter:title" content="Contact - Craft Gifts | Ia Legătura cu Noi">
    <meta property="twitter:description" content="Contactează-ne pentru întrebări despre produsele handmade, comenzi personalizate sau orice alte informații.">
    <meta property="twitter:image" content="{{ asset('images/transparent.jpg') }}">
    
    <!-- Canonical URL -->
    <link rel="canonical" href="{{ route('contact') }}">
    
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=playfair-display:400,600,700|inter:400,500,600&display=swap" rel="stylesheet" />
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        .font-playfair { font-family: 'Playfair Display', serif; }
        .hero-gradient {
            background: linear-gradient(135deg, rgba(219, 28, 181, 0.08) 0%, rgba(246, 241, 235, 1) 100%);
        }
    </style>
    
    <!-- Schema.org ContactPage Structured Data -->
    <script type="application/ld+json">
    {
        "context": "https://schema.org",
        "type": "ContactPage",
        "name": "Contact Craft Gifts",
        "description": "Contactează-ne pentru întrebări despre produsele handmade, comenzi personalizate sau orice alte informații.",
        "url": "{{ route('contact') }}",
        "mainEntity": {
            "type": "Organization",
            "name": "Craft Gifts",
            "url": "{{ route('home') }}",
            "logo": "{{ asset('images/transparent.png') }}",
            "contactPoint": [
                {
                    "type": "ContactPoint",
                    "telephone": "+40-722-739-278",
                    "contactType": "Customer Service",
                    "email": "{{ config('mail.admin_email') }}",
                    "availableLanguage": ["Romanian"],
                    "areaServed": "RO"
                }
            ],
            "sameAs": [
                "https://www.facebook.com/profile.php?id=61586880062880",
                "https://www.instagram.com/craftgiftshandmade/"
            ]
        }
    }
    </script>
    
    <!-- BreadcrumbList Schema -->
    <script type="application/ld+json">
    {
        "context": "https://schema.org",
        "type": "BreadcrumbList",
        "itemListElement": [
            {
                "type": "ListItem",
                "position": 1,
                "name": "Acasă",
                "item": "{{ route('home') }}"
            },
            {
                "type": "ListItem",
                "position": 2,
                "name": "Contact",
                "item": "{{ route('contact') }}"
            }
        ]
    }
    </script>
    
    <!-- FAQ Schema for Contact Page -->
    <script type="application/ld+json">
    {
        "context": "https://schema.org",
        "type": "FAQPage",
        "mainEntity": [
            {
                "type": "Question",
                "name": "Cât durează procesarea unei comenzi?",
                "acceptedAnswer": {
                    "type": "Answer",
                    "text": "De obicei, procesăm comenzile în 1-3 zile lucrătoare. Pentru comenzi personalizate, timpul de execuție poate varia între 5-10 zile lucrătoare, în funcție de complexitate."
                }
            },
            {
                "type": "Question",
                "name": "Puteți realiza comenzi personalizate?",
                "acceptedAnswer": {
                    "type": "Answer",
                    "text": "Da, cu siguranță! Ne place să creăm piese unice după specificațiile tale. Contactează-ne prin formularul de contact sau la email cu detaliile dorite și îți vom trimite o ofertă personalizată."
                }
            },
            {
                "type": "Question",
                "name": "Ce metode de plată acceptați?",
                "acceptedAnswer": {
                    "type": "Answer",
                    "text": "Acceptăm plata online cu cardul (Visa, Mastercard) prin Stripe și ramburs la primirea coletului. Pentru comenzi mari, putem discuta și alte opțiuni de plată."
                }
            },
            {
                "type": "Question",
                "name": "Oferiți returnări?",
                "acceptedAnswer": {
                    "type": "Answer",
                    "text": "Da, poți returna produsele în termen de 14 zile de la primire, dacă acestea sunt în starea originală. Produsele personalizate nu pot fi returnate. Contactează-ne pentru detalii despre procesul de returnare."
                }
            }
        ]
    }
    </script>
</head>
<body class="antialiased font-sans bg-background">
    <!-- Navigation -->
    <livewire:layout.navigation />

    <!-- Hero Section -->
    <section class="pt-32 pb-20 hero-gradient">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-4xl mx-auto">
                <h1 class="text-4xl sm:text-5xl md:text-6xl font-playfair font-bold text-text mb-6 leading-tight">
                    Hai să Vorbim!
                </h1>
                <p class="text-lg sm:text-xl text-gray-600 leading-relaxed">
                    Suntem aici să te ajutăm cu orice întrebare sau cerere specială. Completează formularul și îți vom răspunde în cel mai scurt timp.
                </p>
            </div>
        </div>
    </section>

    <!-- Contact Info Cards -->
    <section class="py-16 sm:py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8 mb-16">
                <!-- Email -->
                <div class="contact-info-card bg-gradient-to-br from-primary-light to-background p-6 sm:p-8 rounded-2xl border border-primary-light">
                    <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center mb-4 shadow-lg">
                        <svg class="w-8 h-8 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-text mb-2">Email</h3>
                    <p class="text-gray-600 mb-3">Trimite-ne un email</p>
                    <a href="mailto:{{ config('mail.admin_email') }}" class="text-primary font-semibold hover:text-primary-dark break-all">
                        {{ config('mail.admin_email') }}
                    </a>
                </div>

                <!-- Telefon -->
                <div class="contact-info-card bg-gradient-to-br from-secondary/20 to-background p-6 sm:p-8 rounded-2xl border border-secondary/30">
                    <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center mb-4 shadow-lg">
                        <svg class="w-8 h-8 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-text mb-2">Telefon</h3>
                    <p class="text-gray-600 mb-3">Sună-ne direct</p>
                    <a href="tel:+40722739278" class="text-secondary font-semibold hover:text-text">
                        +40 722-739-278
                    </a>
                </div>

                <!-- Social Media -->
                <div class="contact-info-card bg-gradient-to-br from-background to-primary-light p-6 sm:p-8 rounded-2xl border border-primary-light sm:col-span-2 lg:col-span-1">
                    <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center mb-4 shadow-lg">
                        <svg class="w-8 h-8 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-text mb-2">Social Media</h3>
                    <p class="text-gray-600 mb-3">Urmărește-ne pe</p>
                    <div class="flex gap-3">
                        <a href="https://www.facebook.com/profile.php?id=61586880062880" class="w-10 h-10 bg-white rounded-full flex items-center justify-center text-primary hover:bg-primary hover:text-white transition-all shadow-md">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                            </svg>
                        </a>
                        <a href="https://www.instagram.com/craftgiftshandmade/" class="w-10 h-10 bg-white rounded-full flex items-center justify-center text-primary hover:bg-primary hover:text-white transition-all shadow-md">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Form Section -->
    <section class="py-16 sm:py-20 bg-background">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl sm:text-4xl font-playfair font-bold text-text mb-4">
                    Trimite-ne un Mesaj
                </h2>
                <p class="text-lg text-gray-600">
                    Completează formularul de mai jos și îți vom răspunde în maxim 24 de ore
                </p>
            </div>

            @if(session('success'))
                <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded-lg">
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <p class="text-green-700 font-medium">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-lg">
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-red-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <p class="text-red-700 font-medium">{{ session('error') }}</p>
                    </div>
                </div>
            @endif

            <div class="bg-white rounded-2xl shadow-xl p-6 sm:p-8 lg:p-10">
                <form action="{{ route('contact.send') }}" method="POST" class="space-y-6">
                    @csrf
                    
                    <div class="grid sm:grid-cols-2 gap-6">
                        <!-- Nume -->
                        <div>
                            <label for="name" class="block text-sm font-semibold text-text mb-2">
                                Nume Complet <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   id="name" 
                                   name="name" 
                                   value="{{ old('name') }}"
                                   required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent transition-all @error('name') border-red-500 @enderror"
                                   placeholder="Ion Popescu">
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-sm font-semibold text-text mb-2">
                                Email <span class="text-red-500">*</span>
                            </label>
                            <input type="email" 
                                   id="email" 
                                   name="email" 
                                   value="{{ old('email') }}"
                                   required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent transition-all @error('email') border-red-500 @enderror"
                                   placeholder="ion@exemplu.ro">
                            @error('email')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="grid sm:grid-cols-2 gap-6">
                        <!-- Telefon -->
                        <div>
                            <label for="phone" class="block text-sm font-semibold text-text mb-2">
                                Telefon (opțional)
                            </label>
                            <input type="tel" 
                                   id="phone" 
                                   name="phone" 
                                   value="{{ old('phone') }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent transition-all @error('phone') border-red-500 @enderror"
                                   placeholder="+40 123 456 789">
                            @error('phone')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Subiect -->
                        <div>
                            <label for="subject" class="block text-sm font-semibold text-text mb-2">
                                Subiect <span class="text-red-500">*</span>
                            </label>
                            <select id="subject" 
                                    name="subject" 
                                    required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent transition-all @error('subject') border-red-500 @enderror">
                                <option value="">Alege un subiect...</option>
                                <option value="Întrebare despre produse" {{ old('subject') == 'Întrebare despre produse' ? 'selected' : '' }}>Întrebare despre produse</option>
                                <option value="Comandă personalizată" {{ old('subject') == 'Comandă personalizată' ? 'selected' : '' }}>Comandă personalizată</option>
                                <option value="Status comandă" {{ old('subject') == 'Status comandă' ? 'selected' : '' }}>Status comandă</option>
                                <option value="Sugestii / Feedback" {{ old('subject') == 'Sugestii / Feedback' ? 'selected' : '' }}>Sugestii / Feedback</option>
                                <option value="Altele" {{ old('subject') == 'Altele' ? 'selected' : '' }}>Altele</option>
                            </select>
                            @error('subject')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Mesaj -->
                    <div>
                        <label for="message" class="block text-sm font-semibold text-text mb-2">
                            Mesaj <span class="text-red-500">*</span>
                        </label>
                        <textarea id="message" 
                                  name="message" 
                                  rows="6" 
                                  required
                                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent transition-all resize-none @error('message') border-red-500 @enderror"
                                  placeholder="Scrie mesajul tău aici...">{{ old('message') }}</textarea>
                        @error('message')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <div class="flex justify-center">
                        <button type="submit" 
                                class="px-8 py-4 bg-gradient-to-r from-primary to-secondary text-white font-semibold rounded-full hover:shadow-xl hover:scale-105 transition-all duration-200 flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                            </svg>
                            Trimite Mesajul
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="py-16 sm:py-20 bg-white">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl sm:text-4xl font-playfair font-bold text-text mb-4">
                    Întrebări Frecvente
                </h2>
                <p class="text-lg text-gray-600">
                    Poate găsești răspunsul la întrebarea ta aici
                </p>
            </div>

            <div class="space-y-4">
                <details class="group bg-background rounded-xl p-6 cursor-pointer hover:bg-primary-light/30 transition-all">
                    <summary class="flex justify-between items-center font-semibold text-text">
                        <span>Cât durează procesarea unei comenzi?</span>
                        <svg class="w-5 h-5 text-primary group-open:rotate-180 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </summary>
                    <p class="mt-4 text-gray-600">
                        De obicei, procesăm comenzile în 1-3 zile lucrătoare. Pentru comenzi personalizate, timpul de execuție poate varia între 5-10 zile lucrătoare, în funcție de complexitate.
                    </p>
                </details>

                <details class="group bg-background rounded-xl p-6 cursor-pointer hover:bg-primary-light/30 transition-all">
                    <summary class="flex justify-between items-center font-semibold text-text">
                        <span>Puteți realiza comenzi personalizate?</span>
                        <svg class="w-5 h-5 text-primary group-open:rotate-180 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </summary>
                    <p class="mt-4 text-gray-600">
                        Da, cu siguranță! Ne place să creăm piese unice după specificațiile tale. Contactează-ne prin formularul de mai sus sau la email cu detaliile dorite și îți vom trimite o ofertă personalizată.
                    </p>
                </details>

                <details class="group bg-background rounded-xl p-6 cursor-pointer hover:bg-primary-light/30 transition-all">
                    <summary class="flex justify-between items-center font-semibold text-text">
                        <span>Ce metode de plată acceptați?</span>
                        <svg class="w-5 h-5 text-primary group-open:rotate-180 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </summary>
                    <p class="mt-4 text-gray-600">
                        Acceptăm plata online cu cardul (Visa, Mastercard) prin Stripe și ramburs la primirea coletului. Pentru comenzi mari, putem discuta și alte opțiuni de plată.
                    </p>
                </details>

                <details class="group bg-background rounded-xl p-6 cursor-pointer hover:bg-primary-light/30 transition-all">
                    <summary class="flex justify-between items-center font-semibold text-text">
                        <span>Oferiți returnări?</span>
                        <svg class="w-5 h-5 text-primary group-open:rotate-180 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </summary>
                    <p class="mt-4 text-gray-600">
                        Da, poți returna produsele în termen de 14 zile de la primire, dacă acestea sunt în starea originală. Produsele personalizate nu pot fi returnate. Contactează-ne pentru detalii despre procesul de returnare.
                    </p>
                </details>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <livewire:layout.footer />
</body>
</html>