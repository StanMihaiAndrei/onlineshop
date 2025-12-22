<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mesaj Nou din Formular Contact</title>
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
            padding: 30px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
        }
        .content {
            padding: 30px;
        }
        .info-row {
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 1px solid #eee;
        }
        .info-row:last-child {
            border-bottom: none;
        }
        .label {
            font-weight: bold;
            color: #db1cb5;
            display: block;
            margin-bottom: 5px;
        }
        .value {
            color: #333;
        }
        .message-box {
            background: #f9f9f9;
            border-left: 4px solid #db1cb5;
            padding: 15px;
            margin-top: 10px;
            border-radius: 5px;
        }
        .footer {
            background: #f9f9f9;
            padding: 20px;
            text-align: center;
            font-size: 12px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>📧 Mesaj Nou din Formular Contact</h1>
        </div>
        
        <div class="content">
            <p>Ai primit un mesaj nou prin formularul de contact al site-ului Craft Gifts:</p>
            
            <div class="info-row">
                <span class="label">👤 Nume:</span>
                <span class="value">{{ $contactData['name'] }}</span>
            </div>
            
            <div class="info-row">
                <span class="label">✉️ Email:</span>
                <span class="value">{{ $contactData['email'] }}</span>
            </div>
            
            @if(!empty($contactData['phone']))
            <div class="info-row">
                <span class="label">📱 Telefon:</span>
                <span class="value">{{ $contactData['phone'] }}</span>
            </div>
            @endif
            
            <div class="info-row">
                <span class="label">📋 Subiect:</span>
                <span class="value">{{ $contactData['subject'] }}</span>
            </div>
            
            <div class="info-row">
                <span class="label">💬 Mesaj:</span>
                <div class="message-box">
                    {{ $contactData['message'] }}
                </div>
            </div>
        </div>
        
        <div class="footer">
            <p>Acest email a fost generat automat de site-ul Craft Gifts.</p>
            <p>Pentru a răspunde clientului, folosește adresa: {{ $contactData['email'] }}</p>
        </div>
    </div>
</body>
</html>