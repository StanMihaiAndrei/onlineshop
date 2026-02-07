<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <title>Despre Noi - Craft Gifts | Povestea Creațiilor Handmade</title>
    <meta name="description" content="Descoperă povestea din spatele Craft Gifts - pasiunea pentru creații handmade unice, dedicarea pentru calitate și dragostea pentru artă. Cunoaște echipa și valorile noastre.">
    
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=playfair-display:400,600,700|inter:400,500,600&display=swap" rel="stylesheet" />
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        .font-playfair { font-family: 'Playfair Display', serif; }
    </style>
</head>
<body class="bg-background">
    <!-- Navigation -->
    <livewire:layout.navigation />

    <!-- Hero Section -->
    <section class="pt-32 pb-20 hero-gradient">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-4xl mx-auto">
                <h1 class="text-4xl sm:text-5xl md:text-6xl font-playfair font-bold text-text mb-6 leading-tight">
                    Povestea Noastră
                </h1>
                <p class="text-lg sm:text-xl text-gray-600 leading-relaxed">
                    O călătorie începută din pasiune pentru frumos, transformată într-o misiune de a aduce bucurie prin creații handmade unice și personale.
                </p>
            </div>
        </div>
    </section>

    <!-- Story Section -->
    <section class="py-16 sm:py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-2 gap-12 items-center">
                <div class="space-y-6">
                    <h2 class="text-3xl sm:text-4xl font-playfair font-bold text-text">
                        De Unde Am Început
                    </h2>
                    <div class="space-y-4 text-gray-600 text-base sm:text-lg leading-relaxed">
                        <p>
                            Craft Gifts a luat naștere din dorința de a crea ceva cu adevărat special - produse care nu doar arată frumos, ci poartă cu sine o poveste, o emoție și o atenție la detaliu care face fiecare piesă unică.
                        </p>
                        <p>
                            Tot ce a început ca un hobby s-a transformat treptat într-o pasiune, iar apoi într-o afacere dedicată creării de decorațiuni handmade, bijuterii artizanale și cadouri personalizate care aduc zâmbete și creează amintiri.
                        </p>
                        <p>
                            Fiecare produs din colecția noastră este realizat manual, cu răbdare și dedicare, folosind materiale de calitate superioară. Nu producem în masă - creăm piese unice care reflectă personalitatea și dorințele tale.
                        </p>
                    </div>
                </div>
                <div class="relative">
                    <img src="{{ asset('images/about-story.jpg') }}" 
                         alt="Povestea Craft Gifts" 
                         class="rounded-2xl shadow-2xl w-full h-[400px] sm:h-[500px] object-cover">
                    <div class="absolute -bottom-6 -right-6 w-32 h-32 bg-primary-light/50 rounded-full blur-3xl"></div>
                    <div class="absolute -top-6 -left-6 w-40 h-40 bg-secondary/30 rounded-full blur-3xl"></div>
                </div>
            </div>
        </div>
    </section>

    <!-- Mission & Vision -->
    <section class="py-16 sm:py-20 bg-background">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12 sm:mb-16">
                <h2 class="text-3xl sm:text-4xl font-playfair font-bold text-text mb-4">
                    Misiunea & Viziunea Noastră
                </h2>
                <p class="text-lg sm:text-xl text-gray-600 max-w-3xl mx-auto">
                    Credem în puterea lucrurilor făcute cu dragoste și dedicare
                </p>
            </div>
            
            <div class="grid sm:grid-cols-2 gap-6 sm:gap-8">
                <div class="bg-white p-6 sm:p-8 rounded-2xl shadow-lg hover-lift">
                    <div class="w-16 h-16 bg-primary-light rounded-full flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-playfair font-bold text-text mb-4">Misiunea Noastră</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Să creăm produse handmade de calitate superioară care aduc bucurie, inspiră creativitatea și celebrează unicitatea fiecărei persoane. Ne dedicăm să transformăm momentele speciale în amintiri de neuitat prin creații artizanale autentice.
                    </p>
                </div>
                
                <div class="bg-white p-6 sm:p-8 rounded-2xl shadow-lg hover-lift">
                    <div class="w-16 h-16 bg-secondary/20 rounded-full flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-playfair font-bold text-text mb-4">Viziunea Noastră</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Să devenim destinația preferată pentru cei care caută produse handmade unice și personalizate în România. Aspirăm să inspirăm o comunitate care apreciază arta manuală și susține creatorii locali.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Values Section -->
    <section class="py-16 sm:py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12 sm:mb-16">
                <h2 class="text-3xl sm:text-4xl font-playfair font-bold text-text mb-4">
                    Valorile Noastre
                </h2>
                <p class="text-lg sm:text-xl text-gray-600 max-w-3xl mx-auto">
                    Principiile care ne ghidează în tot ce facem
                </p>
            </div>
            
            <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6 sm:gap-8">
                <div class="text-center p-6 hover-lift bg-background rounded-xl">
                    <div class="w-16 h-16 bg-primary-light rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-text mb-2">Pasiune</h3>
                    <p class="text-gray-600 text-sm">Iubim ceea ce facem și se vede în fiecare detaliu</p>
                </div>
                
                <div class="text-center p-6 hover-lift bg-background rounded-xl">
                    <div class="w-16 h-16 bg-secondary/20 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-text mb-2">Unicitate</h3>
                    <p class="text-gray-600 text-sm">Fiecare piesă este specială și irrepetabilă</p>
                </div>
                
                <div class="text-center p-6 hover-lift bg-background rounded-xl">
                    <div class="w-16 h-16 bg-primary-light rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-text mb-2">Calitate</h3>
                    <p class="text-gray-600 text-sm">Folosim doar materiale premium de cea mai bună calitate</p>
                </div>
                
                <div class="text-center p-6 hover-lift bg-background rounded-xl">
                    <div class="w-16 h-16 bg-secondary/20 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-text mb-2">Comunitate</h3>
                    <p class="text-gray-600 text-sm">Construim relații pe termen lung cu clienții noștri</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Process Section -->
    <section class="py-16 sm:py-20 bg-background">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12 sm:mb-16">
                <h2 class="text-3xl sm:text-4xl font-playfair font-bold text-text mb-4">
                    Procesul Nostru Creativ
                </h2>
                <p class="text-lg sm:text-xl text-gray-600 max-w-3xl mx-auto">
                    De la idee la produsul finit - fiecare pas este realizat cu atenție la detalii
                </p>
            </div>
            
            <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6 sm:gap-8">
                <div class="bg-white p-6 rounded-xl shadow-lg">
                    <div class="w-12 h-12 bg-primary-light rounded-full flex items-center justify-center mb-4 mx-auto">
                        <span class="text-2xl font-bold text-primary">1</span>
                    </div>
                    <h3 class="text-lg font-bold text-text mb-2 text-center">Inspirație</h3>
                    <p class="text-gray-600 text-sm text-center">Căutăm inspirație în natură, artă și dorințele clienților noștri</p>
                </div>
                
                <div class="bg-white p-6 rounded-xl shadow-lg">
                    <div class="w-12 h-12 bg-secondary/20 rounded-full flex items-center justify-center mb-4 mx-auto">
                        <span class="text-2xl font-bold text-secondary">2</span>
                    </div>
                    <h3 class="text-lg font-bold text-text mb-2 text-center">Design</h3>
                    <p class="text-gray-600 text-sm text-center">Schițăm și planificăm fiecare detaliu cu atenție</p>
                </div>
                
                <div class="bg-white p-6 rounded-xl shadow-lg">
                    <div class="w-12 h-12 bg-primary-light rounded-full flex items-center justify-center mb-4 mx-auto">
                        <span class="text-2xl font-bold text-primary">3</span>
                    </div>
                    <h3 class="text-lg font-bold text-text mb-2 text-center">Creație</h3>
                    <p class="text-gray-600 text-sm text-center">Realizăm manual fiecare piesă cu materiale premium</p>
                </div>
                
                <div class="bg-white p-6 rounded-xl shadow-lg">
                    <div class="w-12 h-12 bg-secondary/20 rounded-full flex items-center justify-center mb-4 mx-auto">
                        <span class="text-2xl font-bold text-secondary">4</span>
                    </div>
                    <h3 class="text-lg font-bold text-text mb-2 text-center">Finalizare</h3>
                    <p class="text-gray-600 text-sm text-center">Verificăm calitatea și împachetăm cu grijă pentru tine</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Team/Artisan Section -->
    <section class="py-16 sm:py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-2 gap-12 items-center">
                <div class="relative order-2 md:order-1">
                    <img src="{{ asset('images/artisan-work.jpg') }}" 
                         alt="Artizani la lucru" 
                         class="rounded-2xl shadow-2xl w-full h-[400px] sm:h-[500px] object-cover">
                    <div class="absolute -bottom-6 -left-6 w-32 h-32 bg-primary-light/50 rounded-full blur-3xl"></div>
                </div>
                <div class="space-y-6 order-1 md:order-2">
                    <h2 class="text-3xl sm:text-4xl font-playfair font-bold text-text">
                        Artizani Pasionați
                    </h2>
                    <div class="space-y-4 text-gray-600 text-base sm:text-lg leading-relaxed">
                        <p>
                            În spatele fiecărui produs Craft Gifts se află ore de muncă, dedicare și o pasiune autentică pentru creația manuală. Echipa noastră este formată din artizani talentați care își pun sufletul în fiecare piesă.
                        </p>
                        <p>
                            Ne mândrim cu abilitățile noastre și experiența acumulată de-a lungul anilor, dar mai presus de toate, ne mândrim cu relațiile pe care le construim cu clienții noștri și cu fericirea pe care produsele noastre o aduc.
                        </p>
                        <p>
                            Fiecare feedback pozitiv, fiecare zâmbet și fiecare poveste pe care o primim de la clienți ne motivează să continuăm să creăm cu pasiune și dedicare.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="py-16 sm:py-20 bg-gradient-to-r from-primary-light to-secondary/20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-6 sm:gap-8">
                <div class="text-center">
                    <div class="text-4xl sm:text-5xl font-bold text-primary mb-2">1000+</div>
                    <div class="text-text font-medium">Clienți Mulțumiți</div>
                </div>
                <div class="text-center">
                    <div class="text-4xl sm:text-5xl font-bold text-secondary mb-2">500+</div>
                    <div class="text-text font-medium">Produse Create</div>
                </div>
                <div class="text-center">
                    <div class="text-4xl sm:text-5xl font-bold text-primary mb-2">100%</div>
                    <div class="text-text font-medium">Handmade</div>
                </div>
                <div class="text-center">
                    <div class="text-4xl sm:text-5xl font-bold text-secondary mb-2">5★</div>
                    <div class="text-text font-medium">Rating Mediu</div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-16 sm:py-20 bg-white">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl sm:text-4xl md:text-5xl font-playfair font-bold text-text mb-6">
                Hai să Creăm Împreună Ceva Special
            </h2>
            <p class="text-lg sm:text-xl text-gray-600 mb-8 max-w-2xl mx-auto">
                Explorează colecțiile noastre sau contactează-ne pentru comenzi personalizate. Suntem aici să transformăm visele tale în realitate!
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                <a href="{{ route('shop') }}" 
                   class="bg-primary text-white px-8 py-3 rounded-full hover:bg-primary-dark transition-all transform hover:scale-105 font-semibold shadow-xl">
                    Descoperă Produsele
                </a>
                <a href="{{ route('contact') }}" 
                   class="border-2 border-primary text-primary px-8 py-3 rounded-full hover:bg-primary hover:text-white transition-all font-semibold">
                    Contactează-ne
                </a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <livewire:layout.footer />
</body>
</html>