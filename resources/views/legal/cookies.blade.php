<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <title>Politica de Cookies - Craft Gifts</title>
    <meta name="description" content="Politica de utilizare cookies Craft Gifts. Aflați ce informații colectăm prin cookies și cum le folosim.">
    
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=playfair-display:400,600,700|inter:400,500,600&display=swap" rel="stylesheet" />
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        .font-playfair { font-family: 'Playfair Display', serif; }
        .text-primary { color: rgb(219, 28, 181); }
        .bg-primary { background-color: rgb(219, 28, 181); }
        
        .hero-legal {
            background: linear-gradient(135deg, rgba(219, 28, 181, 0.1) 0%, rgba(147, 51, 234, 0.1) 100%);
        }
    </style>
</head>
<body class="antialiased font-sans bg-white">
    <!-- Navigation -->
    <livewire:layout.navigation />

    <!-- Hero Section -->
    <section class="pt-32 pb-16 hero-legal">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h1 class="text-4xl md:text-5xl font-playfair font-bold text-gray-900 mb-4">
                    Politica de Cookies
                </h1>
                <p class="text-lg text-gray-600">
                    Cum utilizăm cookies pe site-ul nostru
                </p>
            </div>
        </div>
    </section>

    <!-- Content Section -->
    <section class="py-16">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="prose prose-lg max-w-none">
                
                <!-- Ce date colectăm -->
                <div class="mb-12">
                    <h2 class="text-3xl font-playfair font-bold text-gray-900 mb-6">Ce Date Colectăm</h2>
                    <div class="text-gray-700 space-y-4 leading-relaxed">
                        <p>Este posibil să colectăm următoarele informații:</p>
                        <ul class="list-disc pl-6 space-y-2">
                            <li>Nume și prenume</li>
                            <li>Date de contact incluzând adresa de email</li>
                            <li>Informații demografice precum codul poștal, preferințe și interese</li>
                            <li>Alte informații relevante pentru chestionare clienți și/sau oferte</li>
                        </ul>
                    </div>
                </div>

                <!-- Ce facem cu informațiile -->
                <div class="mb-12">
                    <h2 class="text-3xl font-playfair font-bold text-gray-900 mb-6">Ce Facem cu Informațiile pe Care le Colectăm</h2>
                    <div class="text-gray-700 space-y-4 leading-relaxed">
                        <p>
                            Avem nevoie de aceste informații pentru a înțelege nevoile dvs. și pentru a vă oferi un serviciu mai bun, în special pentru următoarele motive:
                        </p>
                        <ul class="list-disc pl-6 space-y-2">
                            <li>Păstrarea evidenței interne</li>
                            <li>Îmbunătățirea produselor și serviciilor noastre</li>
                            <li>Trimiterea de e-mailuri promoționale despre produse noi, oferte speciale sau alte informații pe care credem că le puteți găsi interesante (doar cu acordul dvs.)</li>
                            <li>Contactarea dvs. în scopuri de cercetare de piață prin e-mail, telefon sau poștă</li>
                            <li>Personalizarea site-ului în funcție de interesele dvs.</li>
                        </ul>
                    </div>
                </div>

                <!-- Securitate -->
                <div class="mb-12">
                    <h2 class="text-3xl font-playfair font-bold text-gray-900 mb-6">Securitate</h2>
                    <div class="text-gray-700 space-y-4 leading-relaxed">
                        <p>
                            Ne-am angajat să vă asigurăm că informațiile dvs. sunt sigure. Pentru a preveni accesul sau dezvăluirea neautorizate, am pus în aplicare proceduri fizice, electronice și manageriale adecvate pentru a proteja și securiza informațiile pe care le colectăm online.
                        </p>
                    </div>
                </div>

                <!-- Cum utilizăm cookie-urile -->
                <div class="mb-12">
                    <h2 class="text-3xl font-playfair font-bold text-gray-900 mb-6">Cum Utilizăm Cookie-urile</h2>
                    <div class="text-gray-700 space-y-4 leading-relaxed">
                        <p>
                            Cookie-ul este un fișier text de mici dimensiuni, format din litere și numere, care va fi stocat pe computerul, terminalul mobil sau alte echipamente ale unui utilizator de pe care se accesează site-ul nostru. Aceste fișiere fac posibilă în principal recunoașterea terminalului utilizatorului și prezentarea conținutului într-un mod relevant, adaptat preferințelor utilizatorului.
                        </p>
                        <p>
                            Cookie-urile asigură utilizatorilor o experiență plăcută de navigare și susțin eforturile noastre pentru a oferi servicii mai adaptate utilizatorilor. Cookie-urile în sine nu solicită informații cu caracter personal pentru a putea fi utilizate și, în multe cazuri, nici nu identifică personal utilizatorii de internet.
                        </p>
                        <p>
                            De asemenea, sunt utilizate în pregătirea unor statistici anonime agregate care ne ajută să înțelegem cum un utilizator beneficiază de paginile noastre de internet, permițându-ne îmbunătățirea structurii și conținutului lor, fără a permite identificarea personală a utilizatorului.
                        </p>
                    </div>
                </div>

                <!-- Lista Cookie-urilor -->
                <div class="mb-12">
                    <h2 class="text-3xl font-playfair font-bold text-gray-900 mb-6">Lista Cookie-urilor pe Care le Colectăm</h2>
                    <div class="text-gray-700 space-y-4 leading-relaxed">
                        <p class="mb-6">Tabelul de mai jos listează cookie-urile pe care le colectăm și ce informații stochează fiecare:</p>
                        
                        <div class="overflow-x-auto">
                            <table class="min-w-full bg-white border border-gray-200 rounded-lg">
                                <thead class="bg-gradient-to-r from-pink-50 to-purple-50">
                                    <tr>
                                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900 border-b">Nume Cookie</th>
                                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900 border-b">Descriere</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 text-sm font-medium text-gray-900">XSRF-TOKEN</td>
                                        <td class="px-6 py-4 text-sm text-gray-700">Cookie de securitate Laravel utilizat pentru protecție împotriva atacurilor CSRF (Cross-Site Request Forgery). Esențial pentru funcționarea corectă a formularelor.</td>
                                    </tr>
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 text-sm font-medium text-gray-900">laravel_session</td>
                                        <td class="px-6 py-4 text-sm text-gray-700">Cookie de sesiune Laravel care identifică sesiunea utilizatorului. Utilizat pentru a păstra starea de autentificare și preferințele pe durata vizitei.</td>
                                    </tr>
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 text-sm font-medium text-gray-900">remember_web_*</td>
                                        <td class="px-6 py-4 text-sm text-gray-700">Cookie care stochează token-ul "Ține-mă minte" pentru autentificare automată. Utilizat doar dacă ați bifat opțiunea "Ține-mă minte" la autentificare.</td>
                                    </tr>
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 text-sm font-medium text-gray-900">livewire</td>
                                        <td class="px-6 py-4 text-sm text-gray-700">Cookie utilizat de Livewire pentru gestionarea componentelor interactive. Asigură funcționarea corectă a coșului de cumpărături și a wishlist-ului.</td>
                                    </tr>
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 text-sm font-medium text-gray-900">cart_session</td>
                                        <td class="px-6 py-4 text-sm text-gray-700">Stochează conținutul coșului de cumpărături pentru utilizatorii neautentificați. Permite păstrarea produselor în coș între sesiuni.</td>
                                    </tr>
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 text-sm font-medium text-gray-900">coupon_code</td>
                                        <td class="px-6 py-4 text-sm text-gray-700">Stochează codul de cupon aplicat în timpul procesului de checkout. Folosit temporar pentru aplicarea reducerilor.</td>
                                    </tr>
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 text-sm font-medium text-gray-900">cookieConsent</td>
                                        <td class="px-6 py-4 text-sm text-gray-700">Stochează consimțământul utilizatorului pentru politica de cookies (acceptat/refuzat). Utilizat în localStorage pentru a nu arăta repeated banner-ul de cookies.</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="bg-blue-50 border-l-4 border-blue-500 p-6 my-6 rounded-r-lg">
                            <p class="text-sm text-blue-900">
                                <strong>Notă:</strong> Toate aceste cookie-uri sunt necesare pentru funcționarea corectă a site-ului și pentru a vă oferi o experiență optimă de cumpărături. Nu folosim cookie-uri de marketing terțe sau de urmărire fără consimțământul dvs.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Link-uri către alte site-uri -->
                <div class="mb-12">
                    <h2 class="text-3xl font-playfair font-bold text-gray-900 mb-6">Link-uri Către Alte Site-uri</h2>
                    <div class="text-gray-700 space-y-4 leading-relaxed">
                        <p>
                            Site-ul nostru poate conține link-uri către alte site-uri de interes. Cu toate acestea, după ce ați utilizat aceste link-uri pentru a părăsi site-ul nostru, trebuie să rețineți că nu avem niciun control asupra acestor site-uri web externe.
                        </p>
                        <p>
                            Prin urmare, nu putem fi responsabili pentru protecția și confidențialitatea informațiilor pe care le furnizați în timp ce vizitați aceste site-uri deoarece aceste site-uri nu sunt reglementate de politica noastră de confidențialitate. Ar trebui să aveți precauție și să consultați declarația de confidențialitate aplicabilă site-ului web în cauză.
                        </p>
                    </div>
                </div>

                <!-- Controlul informațiilor -->
                <div class="mb-12">
                    <h2 class="text-3xl font-playfair font-bold text-gray-900 mb-6">Controlul Informațiilor Dvs. Personale</h2>
                    <div class="text-gray-700 space-y-4 leading-relaxed">
                        <p>Puteți alege să restricționați colectarea sau utilizarea informațiilor dvs. personale în următoarele moduri:</p>
                        <ul class="list-disc pl-6 space-y-2">
                            <li>De fiecare dată când vi se solicită să completați un formular pe site-ul web, căutați căsuța pe care puteți face clic pentru a indica faptul că nu doriți ca informațiile să fie utilizate de nimeni în scopuri de marketing direct</li>
                            <li>Dacă ne-ați dat acordul în prealabil pentru utilizarea informațiilor dvs. personale în scopuri de marketing direct, vă puteți schimba opțiunea în orice moment, anunțându-ne despre acest lucru prin formularul de contact</li>
                        </ul>
                        <p class="mt-4 font-semibold text-gray-900">
                            Nu vom vinde, distribui sau închiria informațiile dvs. personale către terți decât dacă avem permisiunea dvs. sau dacă legea ne obligă să o facem.
                        </p>
                        <p>
                            Puteți solicita detalii despre informațiile personale pe care le deținem despre dvs. în baza Regulamentului (UE) 2016/679 ("Regulamentul general privind protecția datelor" sau "GDPR"), precum și a oricăror alte legislații aplicabile pe teritoriul României. Dacă doriți o copie a informațiilor deținute, vă rugăm să ne trimiteți prin e-mail această solicitare utilizând informațiile noastre de contact.
                        </p>
                        <p>
                            Dacă credeți că informațiile pe care le deținem sunt incorecte sau incomplete, vă rugăm să ne scrieți sau să ne trimiteți un e-mail cât mai curând posibil. Vom corecta prompt orice informație considerată incorectă.
                        </p>
                    </div>
                </div>

                <!-- Contact -->
                <div class="bg-gradient-to-br from-pink-50 to-purple-50 rounded-2xl p-8 mt-12">
                    <h3 class="text-2xl font-playfair font-bold text-gray-900 mb-4">Contactați-ne</h3>
                    <div class="text-gray-700 space-y-2">
                        <p>Pentru întrebări despre politica noastră de cookies, vă rugăm să ne contactați:</p>
                        <p>Email: <a href="mailto:contactcraftgifts@gmail.com" class="text-primary hover:underline font-semibold">contactcraftgifts@gmail.com</a></p>
                        <p>Tel: <a href="tel:0722739278" class="text-primary hover:underline font-semibold">0722 739 278</a></p>
                    </div>
                </div>

                <div class="mt-12 text-center text-gray-600">
                    <p class="text-sm">Ultima actualizare: {{ date('d.m.Y') }}</p>
                </div>

            </div>
        </div>
    </section>

    <!-- Footer -->
    <livewire:layout.footer />
</body>
</html>