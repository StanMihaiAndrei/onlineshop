<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verificare Email</title>
    <style>
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            line-height: 1.6;
            color: #3a3a3a;
            background-color: #f6f1eb;
            margin: 0;
            padding: 0;
        }
        .email-wrapper {
            background-color: #f6f1eb;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background: #ffffff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        .header {
            background-color: #db1cb5;
            color: white;
            padding: 40px 30px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 28px;
            font-weight: 600;
        }
        .header .icon {
            font-size: 48px;
            margin-bottom: 10px;
        }
        .content {
            padding: 40px 30px;
        }
        .content h2 {
            color: #b01691;
            margin-top: 0;
            font-size: 24px;
        }
        .content p {
            margin: 15px 0;
            font-size: 16px;
            color: #3a3a3a;
        }
        .button {
            display: inline-block;
            padding: 15px 40px;
            background-color: #db1cb5;
            color: white !important;
            text-decoration: none;
            border-radius: 8px;
            margin: 25px 0;
            font-weight: bold;
            font-size: 16px;
            transition: all 0.3s ease;
        }
        .button:hover {
            background-color: #b01691;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(219, 28, 181, 0.3);
        }
        .button-container {
            text-align: center;
            margin: 30px 0;
        }
        .info-box {
            background-color: #f0d5ea;
            border-left: 4px solid #db1cb5;
            padding: 15px;
            margin: 20px 0;
            border-radius: 5px;
            color: #3a3a3a;
        }
        .benefits-list {
            background-color: #e8f4f0;
            border-left: 4px solid #8fae9e;
            padding: 15px 15px 15px 35px;
            margin: 20px 0;
            border-radius: 5px;
        }
        .benefits-list li {
            margin: 10px 0;
            color: #3a3a3a;
        }
        .note-box {
            background-color: #fef3c7;
            border-left: 4px solid #f59e0b;
            padding: 15px;
            margin: 20px 0;
            border-radius: 5px;
            color: #92400e;
        }
        .footer {
            background-color: #f6f1eb;
            padding: 30px;
            text-align: center;
            font-size: 13px;
            color: #6b7280;
        }
        .footer a {
            color: #db1cb5;
            text-decoration: none;
            font-weight: 600;
        }
        .footer a:hover {
            color: #b01691;
        }
        .subcopy {
            margin-top: 25px;
            padding-top: 25px;
            border-top: 1px solid #e0e0e0;
            font-size: 12px;
            color: #6b7280;
        }
        .subcopy a {
            color: #db1cb5;
            word-break: break-all;
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="email-wrapper">
        <div class="container">
            <div class="header">
                <div class="icon">&#9993;</div>
                <h1>Bun venit la {{ config('app.name') }}!</h1>
            </div>
            
            <div class="content">
                <h2>Salut, {{ $user->name }}! &#128075;</h2>
                
                <p><strong>Mulțumim că te-ai alăturat comunității noastre!</strong></p>
                
                <p>Pentru a-ți activa contul și a beneficia de toate funcționalitățile platformei, te rugăm să îți verifici adresa de email făcând clic pe butonul de mai jos:</p>
                
                <div class="button-container">
                    <a href="{{ $verificationUrl }}" class="button">
                        &#128275; Verifică Adresa de Email
                    </a>
                </div>
                
                <div class="info-box">
                    <strong>&#9719; Important:</strong> Acest link de verificare este valabil timp de <strong>60 de minute</strong>. După expirare, vei putea solicita un nou link din contul tău.
                </div>
                
                <p><strong>&#9733; După verificarea email-ului, vei putea:</strong></p>
                <ul class="benefits-list">
                    <li>&#10003; Accesa toate funcționalitățile contului</li>
                    <li>&#128722; Plasa comenzi</li>
                    <li>&#128230; Urmări statusul comenzilor tale</li>
                    <li>&#9829; Salva produse favorite</li>
                </ul>
                
                <div class="note-box">
                    <strong>&#9888; Nu ai creat tu acest cont?</strong><br>
                    Dacă nu ai solicitat crearea acestui cont, te rugăm să ignori acest email. Contul nu va fi activat fără confirmarea ta.
                </div>
                
                <p style="margin-top: 30px;">Cu drag,<br>
                <strong style="color: #b01691;">Echipa {{ config('app.name') }}</strong></p>
                
                <div class="subcopy">
                    <p><strong>Probleme cu butonul?</strong> Copiază și lipește acest link în browser:</p>
                    <p><a href="{{ $verificationUrl }}">{{ $verificationUrl }}</a></p>
                </div>
            </div>
            
            <div class="footer">
                <p><strong style="color: #3a3a3a;">{{ config('app.name') }}</strong></p>
                <p style="margin: 10px 0;">&copy; {{ date('Y') }} Toate drepturile rezervate.</p>
                <p>
                    <a href="{{ config('app.url') }}">Vizitează site-ul</a> | 
                    <a href="{{ config('app.url') }}/contact">Contact</a>
                </p>
            </div>
        </div>
    </div>
</body>
</html>