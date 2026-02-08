<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comandă confirmată</title>
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
            margin: 0 0 10px 0;
            font-size: 28px;
            font-weight: 600;
        }
        .header p {
            margin: 0;
            font-size: 16px;
            opacity: 0.95;
        }
        .content {
            padding: 30px;
        }
        .greeting {
            font-size: 18px;
            color: #3a3a3a;
            margin-bottom: 20px;
        }
        .section {
            background: #f6f1eb;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
            border-left: 4px solid #db1cb5;
        }
        .section-title {
            margin-top: 0;
            color: #b01691;
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 15px;
        }
        .info-row {
            margin: 10px 0;
            color: #3a3a3a;
        }
        .info-row strong {
            color: #b01691;
            display: inline-block;
            min-width: 120px;
        }
        .coupon-box { 
            background-color: #f0d5ea;
            border: 3px solid #db1cb5; 
            border-radius: 10px; 
            padding: 25px; 
            margin: 25px 0;
            text-align: center;
        }
        .coupon-code {
            font-size: 32px;
            font-weight: bold;
            color: #b01691;
            letter-spacing: 3px;
            margin: 15px 0;
            font-family: 'Courier New', monospace;
            padding: 10px;
            background: #ffffff;
            border-radius: 5px;
        }
        .savings {
            font-size: 24px;
            color: #8fae9e;
            font-weight: bold;
            margin: 15px 0;
        }
        .shipping-box {
            background-color: #e8f4f0;
            border: 2px solid #8fae9e;
            border-radius: 8px;
            padding: 20px;
            margin: 20px 0;
        }
        .awb-box {
            background-color: #d5f0e8;
            border-left: 4px solid #8fae9e;
            padding: 15px;
            border-radius: 6px;
            margin-top: 15px;
        }
        .item { 
            border-bottom: 1px solid #e0e0e0; 
            padding: 12px 0;
        }
        .item:last-child { 
            border-bottom: none; 
        }
        .total-section { 
            background: #ffffff; 
            border-radius: 8px; 
            padding: 20px; 
            margin-top: 20px;
            border: 1px solid #e0e0e0;
        }
        .total-row { 
            display: flex; 
            justify-content: space-between; 
            margin: 10px 0;
            font-size: 15px;
        }
        .total-row.discount { 
            color: #8fae9e; 
            font-weight: bold;
        }
        .total-row.shipping { 
            color: #db1cb5; 
            font-weight: 600;
        }
        .total-row.final { 
            margin-top: 15px; 
            padding-top: 15px; 
            border-top: 2px solid #db1cb5;
            font-size: 22px;
            font-weight: bold;
            color: #b01691;
        }
        .info-notice {
            background-color: #f0f9ff;
            border-left: 4px solid #8fae9e;
            padding: 15px;
            border-radius: 4px;
            margin: 20px 0;
        }
        .footer {
            background-color: #f6f1eb;
            padding: 30px;
            text-align: center;
            color: #6b7280;
            font-size: 14px;
        }
        .footer a {
            color: #db1cb5;
            text-decoration: none;
            font-weight: 600;
        }
        .badge {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 4px;
            font-size: 13px;
            font-weight: 600;
        }
        .badge-success {
            background-color: #d5f0e8;
            color: #047857;
        }
        .badge-warning {
            background-color: #fef3c7;
            color: #92400e;
        }
        .icon {
            display: inline-block;
            width: 20px;
            text-align: center;
            margin-right: 5px;
        }
    </style>
</head>
<body>
    <div class="email-wrapper">
        <div class="container">
            <div class="header">
                <h1>&#10004; Comandă confirmată!</h1>
                <p>Mulțumim pentru comanda ta #{{ $order->order_number }}</p>
            </div>

            <div class="content">
                <p class="greeting">Bună <strong>{{ $order->shipping_name }}</strong>,</p>
                
                <p>Comanda ta a fost plasată cu succes și va fi procesată în curând.</p>

                @if($order->coupon_id && $order->discount_amount > 0)
                    <div class="coupon-box">
                        <div style="font-size: 18px; color: #b01691; margin-bottom: 10px;">
                            <strong>&#9733; Felicitări! Ai aplicat un cupon! &#9733;</strong>
                        </div>
                        <div class="coupon-code">
                            {{ $order->coupon->code }}
                        </div>
                        <div class="savings">
                            &#8226; Ai economisit: RON {{ number_format($order->discount_amount, 2) }}
                        </div>
                        <div style="font-size: 14px; color: #6b7280; margin-top: 10px;">
                            @if($order->coupon->type === 'percentage')
                                ({{ $order->coupon->value }}% reducere aplicată)
                            @else
                                (Reducere fixă aplicată)
                            @endif
                        </div>
                    </div>
                @endif

                <div class="section">
                    <h3 class="section-title">&#9679; Detalii comandă</h3>
                    <div class="info-row"><strong>Număr comandă:</strong> {{ $order->order_number }}</div>
                    <div class="info-row"><strong>Data:</strong> {{ $order->created_at->format('d/m/Y H:i') }}</div>

                    <div class="info-row"><strong>Metodă plată:</strong> {{ $order->payment_method === 'card' ? '💳 Card bancar' : '💵 Ramburs la livrare' }}</div>
                    @if($invoiceSeries && $invoiceNumber)
                        <div class="info-row">
                            <strong>&#9776; Factură:</strong> 
                            <span style="color: #8fae9e; font-weight: bold;">{{ $invoiceSeries }}{{ $invoiceNumber }}</span>
                        </div>
                        <div style="background: #d5f0e8; border-left: 4px solid #8fae9e; padding: 12px; border-radius: 4px; margin: 10px 0;">
                            <p style="margin: 0; color: #047857; font-size: 14px;">
                                <strong>&#128206; Factura este atașată la acest email în format PDF.</strong>
                            </p>
                        </div>
                    @endif

                    <div class="info-row">
                        <strong>Status plată:</strong> 
                        <span class="badge {{ $order->payment_status === 'paid' ? 'badge-success' : 'badge-warning' }}">
                            {{ $order->payment_status === 'paid' ? '✅ Plătit' : '⏳ În așteptare' }}
                        </span>
                    </div>
                </div>

                <div class="shipping-box">
                    <h3 class="section-title" style="color: #8fae9e;">&#9733; Informații livrare</h3>
                    
                    <div class="info-row"><strong>Tip livrare:</strong> 
                        @if($order->delivery_type === 'home')
                            &#9873; Livrare la domiciliu
                        @else
                            &#9633; Livrare la EasyBox
                        @endif
                    </div>

                    @if($order->delivery_type === 'home')
                        <h4 style="margin: 15px 0 10px 0; color: #b01691; font-size: 15px;">&#9872; Adresa de livrare:</h4>
                        <div style="padding: 10px; background: #ffffff; border-radius: 5px;">
                            {{ $order->shipping_address }}<br>
                            {{ $order->shipping_city }}@if($order->shipping_postal_code), {{ $order->shipping_postal_code }}@endif<br>
                            {{ $order->shipping_country }}<br>
                            &#9742; Tel: {{ $order->shipping_phone }}
                        </div>
                    @else
                        <h4 style="margin: 15px 0 10px 0; color: #b01691; font-size: 15px;">&#9633; Punct EasyBox:</h4>
                        <div style="padding: 10px; background: #ffffff; border-radius: 5px;">
                            <strong>{{ $order->sameday_locker_name }}</strong><br>
                            {{ $order->shipping_city }}<br>
                            &#9742; Tel contact: {{ $order->shipping_phone }}
                        </div>
                        <div style="margin-top: 10px; padding: 10px; background: #fef3c7; border-radius: 6px; font-size: 14px;">
                            <strong>&#9432; Notă:</strong> Vei primi un SMS/email cu codul de deschidere a EasyBox-ului când coletul va ajunge la destinație.
                        </div>
                    @endif

                    @if($order->sameday_awb_number)
                        <div class="awb-box">
                            <div style="font-weight: bold; margin-bottom: 5px;">&#9635; AWB (Nr. Colet):</div>
                            <div style="font-size: 20px; font-weight: bold; color: #047857; font-family: 'Courier New', monospace;">
                                {{ $order->sameday_awb_number }}
                            </div>
                            <div style="margin-top: 10px; font-size: 14px; color: #6b7280;">
                                Poți urmări coletul pe <a href="https://sameday.ro/awb-tracking/?awb={{ $order->sameday_awb_number }}" target="_blank" style="color: #8fae9e; text-decoration: underline;">sameday.ro/awb-tracking</a>
                            </div>
                        </div>
                    @endif
                </div>

                <div class="section">
                    <h3 class="section-title">&#9776; Produse comandate</h3>
                    
                    @php
                        $subtotal = 0;
                    @endphp
                    @foreach($order->items as $item)
                        @php
                            $subtotal += $item->subtotal;
                        @endphp
                        <div class="item">
                            <strong style="color: #3a3a3a; font-size: 15px;">{{ $item->product_title }}</strong><br>
                            <span style="color: #6b7280; font-size: 14px;">
                                Cantitate: {{ $item->quantity }} × RON {{ number_format($item->price, 2) }} = 
                                <strong style="color: #3a3a3a;">RON {{ number_format($item->subtotal, 2) }}</strong>
                            </span>
                        </div>
                    @endforeach
                    
                    <div class="total-section">
                        <div class="total-row">
                            <span>Subtotal produse:</span>
                            <span style="font-weight: 600;">RON {{ number_format($subtotal, 2) }}</span>
                        </div>
                        
                        @if($order->discount_amount > 0)
                            <div class="total-row discount">
                                <span>&#9733; Reducere ({{ $order->coupon->code }}):</span>
                                <span>-RON {{ number_format($order->discount_amount, 2) }}</span>
                            </div>
                        @endif
                        
                        <div class="total-row shipping">
                            <span>&#9873; Transport ({{ $order->delivery_type === 'home' ? 'Domiciliu' : 'EasyBox' }}):</span>
                            <span>
                                @if($order->shipping_cost > 0)
                                    RON {{ number_format($order->shipping_cost, 2) }}
                                @else
                                    GRATUIT
                                @endif
                            </span>
                        </div>
                        
                        <div class="total-row final">
                            <span>Total de plată:</span>
                            <span>RON {{ number_format($order->total_amount, 2) }}</span>
                        </div>
                    </div>
                </div>

                <div class="info-notice">
                    <strong>&#9993; Notificare:</strong> Vei primi un email cu actualizarea statusului comenzii și numărul AWB când coletul va fi preluat de curier.
                </div>
            </div>

            <div class="footer">
                <p>Pentru întrebări, ne poți contacta la: <a href="mailto:contact@craftgits.ro">contact@craftgits.ro</a></p>
                <p style="margin-top: 15px; font-size: 16px; color: #3a3a3a;">
                    <strong>Mulțumim că ai ales CraftGits Shop!</strong>
                </p>
                <p style="margin-top: 10px; font-size: 12px; color: #9ca3af;">
                    &copy; {{ date('Y') }} CraftGits. Toate drepturile rezervate.
                </p>
            </div>
        </div>
    </div>
</body>
</html>