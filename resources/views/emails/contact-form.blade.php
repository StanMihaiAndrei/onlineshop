<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mesaj Nou din Formular Contact</title>
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
            background-color: #8fae9e;
            color: white;
            padding: 30px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
            font-weight: 600;
        }
        .content {
            padding: 30px;
        }
        .intro {
            background-color: #f0d5ea;
            border-left: 4px solid #db1cb5;
            padding: 15px;
            margin-bottom: 25px;
            border-radius: 5px;
            color: #3a3a3a;
        }
        .info-row {
            background-color: #f6f1eb;
            margin-bottom: 15px;
            padding: 15px;
            border-radius: 8px;
            border-left: 4px solid #8fae9e;
        }
        .info-row:last-of-type {
            margin-bottom: 0;
        }
        .label {
            font-weight: bold;
            color: #b01691;
            display: block;
            margin-bottom: 8px;
            font-size: 14px;
        }
        .value {
            color: #3a3a3a;
            font-size: 15px;
        }
        .value a {
            color: #db1cb5;
            text-decoration: none;
            font-weight: 600;
        }
        .value a:hover {
            color: #b01691;
            text-decoration: underline;
        }
        .message-box {
            background: #ffffff;
            border: 1px solid #e0e0e0;
            border-left: 4px solid #db1cb5;
            padding: 15px;
            margin-top: 10px;
            border-radius: 5px;
            color: #3a3a3a;
            line-height: 1.8;
        }
        .footer {
            background-color: #f6f1eb;
            padding: 25px;
            text-align: center;
            font-size: 13px;
            color: #6b7280;
            border-top: 2px solid #e0e0e0;
        }
        .footer p {
            margin: 8px 0;
        }
        .footer a {
            color: #db1cb5;
            text-decoration: none;
            font-weight: 600;
        }
        .footer a:hover {
            color: #b01691;
        }
        .reply-notice {
            background-color: #e8f4f0;
            border: 2px solid #8fae9e;
            padding: 15px;
            border-radius: 8px;
            margin-top: 20px;
            text-align: center;
        }
        .reply-notice strong {
            color: #047857;
        }
    </style>
</head>
<body>
    <div class="email-wrapper">
        <div class="container">
            <div class="header">
                <h1>&#9993; Mesaj Nou din Formular Contact</h1>
            </div>
            
            <div class="content">
                <div class="intro">
                    <strong>&#9733; Notificare:</strong> Ai primit un mesaj nou prin formularul de contact al site-ului <strong>{{ config('app.name') }}</strong>
                </div>
                
                <div class="info-row">
                    <span class="label">&#128100; Nume complet:</span>
                    <span class="value">{{ $contactData['name'] }}</span>
                </div>
                
                <div class="info-row">
                    <span class="label">&#9993; Adresă email:</span>
                    <span class="value">
                        <a href="mailto:{{ $contactData['email'] }}">{{ $contactData['email'] }}</a>
                    </span>
                </div>
                
                @if(!empty($contactData['phone']))
                <div class="info-row">
                    <span class="label">&#128222; Telefon:</span>
                    <span class="value">
                        <a href="tel:{{ $contactData['phone'] }}">{{ $contactData['phone'] }}</a>
                    </span>
                </div>
                @endif
                
                <div class="info-row">
                    <span class="label">&#128196; Subiect:</span>
                    <span class="value"><strong>{{ $contactData['subject'] }}</strong></span>
                </div>
                
                <div class="info-row">
                    <span class="label">&#128172; Mesajul complet:</span>
                    <div class="message-box">
                        {{ $contactData['message'] }}
                    </div>
                </div>

                <div class="reply-notice">
                    <p style="margin: 0;">
                        <strong>&#9993; Pentru a răspunde clientului</strong><br>
                        Trimite un email la: <a href="mailto:{{ $contactData['email'] }}" style="color: #047857; text-decoration: none; font-weight: bold;">{{ $contactData['email'] }}</a>
                    </p>
                </div>
            </div>
            
            <div class="footer">
                <p><strong style="color: #3a3a3a;">{{ config('app.name') }}</strong></p>
                <p style="margin-top: 10px;">&#9432; Acest email a fost generat automat de sistemul de contact.</p>
                <p style="margin-top: 10px;">&copy; {{ date('Y') }} Toate drepturile rezervate.</p>
            </div>
        </div>
    </div>
</body>
</html>