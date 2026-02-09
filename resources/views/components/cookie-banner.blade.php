<div id="cookieBanner" class="hidden fixed bottom-0 left-0 right-0 z-50 p-4 bg-white border-t-2 border-pink-500 shadow-2xl">
    <div class="max-w-7xl mx-auto">
        <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
            <div class="flex-1 text-sm text-gray-700">
                <p>
                    🍪 Folosim cookies pentru a îmbunătăți experiența ta pe site-ul nostru. Acestea ne ajută să păstrăm coșul tău de cumpărături și preferințele tale.
                    <a href="{{ route('legal.cookies') }}" class="text-pink-600 hover:text-pink-700 underline font-medium">Citește politica de cookies</a>
                </p>
            </div>
            <div class="flex gap-3 flex-shrink-0">
                <button onclick="acceptCookies()" class="px-6 py-2.5 bg-gradient-to-r from-pink-600 to-purple-600 text-white font-semibold rounded-lg hover:from-pink-700 hover:to-purple-700 transition-all duration-200 shadow-md hover:shadow-lg">
                    Accept
                </button>
                <button onclick="declineCookies()" class="px-6 py-2.5 bg-gray-200 text-gray-700 font-semibold rounded-lg hover:bg-gray-300 transition-all duration-200">
                    Refuz
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    // Verifică dacă utilizatorul a acceptat sau refuzat deja cookies
    function checkCookieConsent() {
        const consent = localStorage.getItem('cookieConsent');
        const banner = document.getElementById('cookieBanner');
        
        // Dacă nu există consimțământ, arată banner-ul
        if (!consent && banner) {
            banner.classList.remove('hidden');
        }
    }

    // Acceptă cookies
    function acceptCookies() {
        localStorage.setItem('cookieConsent', 'accepted');
        localStorage.setItem('cookieConsentDate', new Date().toISOString());
        hideCookieBanner();
    }

    // Refuză cookies (dar păstrăm esențialele pentru funcționarea site-ului)
    function declineCookies() {
        localStorage.setItem('cookieConsent', 'declined');
        localStorage.setItem('cookieConsentDate', new Date().toISOString());
        hideCookieBanner();
        
        // Opțional: poți adăuga logică pentru a dezactiva cookies non-esențiale
        // De exemplu: dezactivarea Google Analytics, Facebook Pixel, etc.
    }

    // Ascunde banner-ul
    function hideCookieBanner() {
        const banner = document.getElementById('cookieBanner');
        if (banner) {
            banner.style.opacity = '0';
            banner.style.transform = 'translateY(100%)';
            banner.style.transition = 'all 0.3s ease-out';
            
            setTimeout(() => {
                banner.classList.add('hidden');
            }, 300);
        }
    }

    // Verifică consimțământul când se încarcă pagina
    document.addEventListener('DOMContentLoaded', checkCookieConsent);
</script>