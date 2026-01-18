<footer id="contact" class="bg-gray-900 text-white py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid md:grid-cols-5 gap-8 mb-12">
            <div class="col-span-2 md:col-span-1">
                <img src="{{ asset('images/transparent.png') }}" alt="Craft Gifts" class="h-16 mb-4">
                <p class="text-gray-400 leading-relaxed">
                    Creații handmade unice pentru momentele tale speciale.
                </p>
                <div class="flex gap-4 mt-6">
                    <a href="https://www.facebook.com/profile.php?id=100093669974583" class="w-10 h-10 bg-white/10 rounded-full flex items-center justify-center hover:bg-pink-600 transition-colors">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                    </a>
                    <a href="https://www.instagram.com/craftgiftshandmade/" class="w-10 h-10 bg-white/10 rounded-full flex items-center justify-center hover:bg-pink-600 transition-colors">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                    </a>
                </div>
            </div>
            
            <div>
                <h3 class="font-bold text-lg mb-4">Link-uri Rapide</h3>
                <ul class="space-y-2">
                    <li><a href="{{ route('home') }}" class="text-gray-400 hover:text-pink-500 transition-colors">Acasă</a></li>
                    <li><a href="{{ route('shop') }}" class="text-gray-400 hover:text-pink-500 transition-colors">Magazin</a></li>
                    <li><a href="{{ route('about') }}" class="text-gray-400 hover:text-pink-500 transition-colors">Despre Noi</a></li>
                    <li><a href="{{ route('contact') }}" class="text-gray-400 hover:text-pink-500 transition-colors">Contact</a></li>
                </ul>
            </div>
            
            <div>
                <h3 class="font-bold text-lg mb-4">Informații</h3>
                <ul class="space-y-2">
                    <li><a href="{{ route('legal.delivery') }}" class="text-gray-400 hover:text-pink-500 transition-colors">Livrare si anulare comenzi</a></li>
                    <li><a href="{{ route('legal.cookies') }}" class="text-gray-400 hover:text-pink-500 transition-colors">Politică Cookies</a></li>
                    <li><a href="{{ route('legal.terms') }}" class="text-gray-400 hover:text-pink-500 transition-colors">Termeni și Condiții</a></li>
                    <li><a href="{{ route('legal.privacy') }}" class="text-gray-400 hover:text-pink-500 transition-colors">Politică Confidențialitate</a></li>
                </ul>
            </div>
            
            <div>
                <h3 class="font-bold text-lg mb-4">Contact</h3>
                <ul class="space-y-2 text-gray-400">
                    <li>Email: <a href="mailto:contact@craftgifts.ro" class="text-gray-400 hover:text-pink-500 transition-colors">contact@craftgifts.ro</a></li>
                    <li>Telefon: <a href="tel:0722739278" class="text-gray-400 hover:text-pink-500 transition-colors">0722 739 278</a></li>
                    <li>Program: L-V 9:00-18:00</li>
                </ul>
            </div>

            <div>
                <h3 class="font-bold text-lg mb-4">Protecția Consumatorului</h3>
                <div class="space-y-3">
                    <a href="https://anpc.ro/ce-este-sal/" target="_blank" rel="noopener noreferrer" class="block hover:opacity-80 transition-opacity">
                        <img src="{{ asset('images/anpc/SAL-PICTOGRAMA.png') }}" alt="Soluționarea Online a Litigiilor" class="h-12 w-auto">
                    </a>
                    <a href="https://ec.europa.eu/consumers/odr" target="_blank" rel="noopener noreferrer" class="block hover:opacity-80 transition-opacity">
                        <img src="{{ asset('images/anpc/pictogramaSOL.png') }}" alt="ANPC Soluționarea Alternativă" class="h-12 w-auto">
                    </a>
                </div>
            </div>
        </div>
        
        <div class="border-t border-gray-800 pt-8 text-center text-gray-400">
            <p>&copy; {{ date('Y') }} Craft Gifts. Toate drepturile rezervate. Realizat cu ❤️ în România de <a class="text-gray-400 hover:text-pink-500 transition-colors" href="https://www.digitalbuild.ro" target="_blank" rel="noopener noreferrer">Digital Build</a></p>
        </div>
    </div>
</footer>