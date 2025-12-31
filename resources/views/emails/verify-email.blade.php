<!-- resources/views/emails/verify-email.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verificare Email</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            background: #ffffff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .header {
            background: linear-gradient(135deg, #db1cb5 0%, #9333ea 100%);
            color: white;
            padding: 40px 30px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 28px;
        }
        .header .icon {
            font-size: 48px;
            margin-bottom: 10px;
        }
        .content {
            padding: 40px 30px;
        }
        .content h2 {
            color: #db1cb5;
            margin-top: 0;
        }
        .content p {
            margin: 15px 0;
            font-size: 16px;
        }
        .button {
            display: inline-block;
            padding: 15px 40px;
            background: linear-gradient(135deg, #db1cb5 0%, #9333ea 100%);
            color: white !important;
            text-decoration: none;
            border-radius: 8px;
            margin: 25px 0;
            font-weight: bold;
            font-size: 16px;
            transition: transform 0.2s;
        }
        .button:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(219, 28, 181, 0.3);
        }
        .button-container {
            text-align: center;
            margin: 30px 0;
        }
        .info-box {
            background: #f9f9f9;
            border-left: 4px solid #db1cb5;
            padding: 15px;
            margin: 20px 0;
            border-radius: 5px;
        }
        .footer {
            background: #f9f9f9;
            padding: 25px;
            text-align: center;
            font-size: 13px;
            color: #666;
            border-top: 1px solid #eee;
        }
        .footer a {
            color: #db1cb5;
            text-decoration: none;
        }
        .subcopy {
            margin-top: 25px;
            padding-top: 25px;
            border-top: 1px solid #eee;
            font-size: 12px;
            color: #888;
        }
        .subcopy a {
            color: #db1cb5;
            word-break: break-all;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="icon">✉️</div>
            <h1>Bun venit la {{ config('app.name') }}!</h1>
        </div>
        
        <div class="content">
            <h2>Salut, {{ $user->name }}! 👋</h2>
            
            <p>Mulțumim că te-ai alăturat comunității noastre!</p>
            
            <p>Pentru a-ți activa contul și a beneficia de toate funcționalitățile platformei, te rugăm să îți verifici adresa de email făcând clic pe butonul de mai jos:</p>
            
            <div class="button-container">
                <a href="{{ $verificationUrl }}" class="button">
                    🔓 Verifică Adresa de Email
                </a>
            </div>
            
            <div class="info-box">
                <strong>⏰ Important:</strong> Acest link de verificare este valabil timp de 60 de minute. După expirare, vei putea solicita un nou link din contul tău.
            </div>
            
            <p>După verificarea email-ului, vei putea:</p>
            <ul>
                <li>✅ Accesa toate funcționalitățile contului</li>
                <li>🛒 Plasa comenzi</li>
                <li>📦 Urmări statusul comenzilor tale</li>
                <li>❤️ Salva produse favorite</li>
            </ul>
            
            <p><strong>Nu ai creat tu acest cont?</strong><br>
            Dacă nu ai solicitat crearea acestui cont, te rugăm să ignori acest email. Contul nu va fi activat fără confirmarea ta.</p>
            
            <p>Cu drag,<br>
            <strong>Echipa {{ config('app.name') }}</strong></p>
            
            <div class="subcopy">
                <p><strong>Probleme cu butonul?</strong> Copiază și lipește acest link în browser:</p>
                <p><a href="{{ $verificationUrl }}">{{ $verificationUrl }}</a></p>
            </div>
        </div>
        
        <div class="footer">
            <p><strong>{{ config('app.name') }}</strong></p>
            <p>© {{ date('Y') }} Toate drepturile rezervate.</p>
            <p>
                <a href="{{ config('app.url') }}">Vizitează site-ul</a> | 
                <a href="{{ config('app.url') }}/contact">Contact</a>
            </p>
        </div>
    </div>
</body>
</html>