<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comandă nouă</title>
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
            max-width: 650px; 
            margin: 0 auto; 
            background: #ffffff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        .header { 
            background-color: #b01691;
            color: white; 
            padding: 40px 30px; 
            text-align: center;
        }
        .header h1 {
            margin: 0 0 10px 0;
            font-size: 28px;
            font-weight: 600;
        }
        .content {
            padding: 30px;
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
        .info-box {
            background: #ffffff;
            padding: 15px;
            border-radius: 6px;
            margin: 15px 0;
            border: 1px solid #e0e0e0;
        }
        .info-row {
            margin: 8px 0;
            color: #3a3a3a;
        }
        .info-row strong {
            color: #b01691;
        }
        .info-row a {
            color: #db1cb5;
            text-decoration: none;
        }
        .warning-box { 
            background-color: #fef3c7;
            border: 3px solid #f59e0b; 
            border-radius: 10px; 
            padding: 20px; 
            margin: 20px 0;
            text-align: center;
        }
        .coupon-code-admin {
            font-size: 28px;
            font-weight: bold;
            color: #d97706;
            letter-spacing: 2px;
            margin: 10px 0;
            font-family: 'Courier New', monospace;
            padding: 10px;
            background: #ffffff;
            border-radius: 5px;
        }
        .shipping-section {
            background-color: #e8f4f0;
            border: 2px solid #8fae9e;
            border-radius: 8px;
            padding: 20px;
            margin: 20px 0;
        }
        .awb-info {
            background-color: #fef3c7;
            border-left: 4px solid #f59e0b;
            padding: 12px;
            border-radius: 6px;
            margin-top: 15px;
        }
        .awb-generated {
            background-color: #d5f0e8;
            border: 2px solid #8fae9e;
            border-radius: 8px;
            padding: 15px;
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
            color: #f59e0b; 
            font-weight: bold;
        }
        .total-row.shipping { 
            color: #8fae9e; 
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
        .admin-notice {
            background-color: #e8f4f0;
            border-left: 4px solid #8fae9e;
            padding: 15px;
            border-radius: 4px;
            margin: 20px 0;
            text-align: center;
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
        .badge-company {
            background-color: #fef3c7;
            color: #f59e0b;
        }
    </style>
</head>
<body>
    <div class="email-wrapper">
        <div class="container">
            <div class="header">
                <h1>&#9733; Comandă nouă pe site!</h1>
                <p>O comandă nouă a fost plasată pe CraftGits Shop</p>
            </div>

            <div class="content">
                @if($order->coupon_id && $order->discount_amount > 0)
                    <div class="warning-box">
                        <div style="font-size: 18px; color: #d97706; margin-bottom: 10px;">
                            <strong>&#9888; ATENȚIE: Cupon aplicat!</strong>
                        </div>
                        <div class="coupon-code-admin">
                            {{ $order->coupon->code }}
                        </div>
                        <div style="font-size: 20px; color: #b45309; font-weight: bold; margin: 10px 0;">
                            &#8226; Reducere: RON {{ number_format($order->discount_amount, 2) }}
                        </div>
                        <div style="font-size: 14px; color: #92400e; margin-top: 10px;">
                            @if($order->coupon->type === 'percentage')
                                Tip: {{ $order->coupon->value }}% reducere aplicată
                            @else
                                Tip: Reducere fixă aplicată
                            @endif
                        </div>
                    </div>
                @endif

                <div class="section">
                    <h2 class="section-title">&#9679; Detalii comandă #{{ $order->order_number }}</h2>
                    
                    <div class="info-box">
                        <h3 style="margin: 0 0 10px 0; color: #b01691; font-size: 16px;">&#9787; Informații client:</h3>
                        <div class="info-row"><strong>Nume:</strong> {{ $order->shipping_name }}</div>
                        <div class="info-row"><strong>Email:</strong> <a href="mailto:{{ $order->shipping_email }}">{{ $order->shipping_email }}</a></div>
                        <div class="info-row"><strong>Telefon:</strong> <a href="tel:{{ $order->shipping_phone }}">{{ $order->shipping_phone }}</a></div>
                        @if($order->is_company)
                            <div class="info-row">
                                <span class="badge badge-company">&#9873; FIRMĂ</span>
                            </div>
                        @endif
                    </div>

                    <div class="info-box">
                        <h3 style="margin: 0 0 10px 0; color: #b01691; font-size: 16px;">&#9776; Informații plată:</h3>
                        <div class="info-row"><strong>Metodă:</strong> {!! $order->payment_method === 'card' ? '&#9776; Card bancar' : '&#9776; Ramburs' !!}</div>
                        <div class="info-row">
                            <strong>Status:</strong> 
                            <span class="badge {{ $order->payment_status === 'paid' ? 'badge-success' : 'badge-warning' }}">
                                {{ $order->payment_status === 'paid' ? '✓ PLĂTIT' : '&#9711; ÎN AȘTEPTARE' }}
                            </span>
                        </div>
                    </div>
                    
                    @if($order->notes)
                        <div style="background: #fef3c7; border-left: 4px solid #f59e0b; padding: 15px; border-radius: 4px; margin: 15px 0;">
                            <div style="font-weight: bold; margin-bottom: 5px;">&#9998; Note comandă:</div>
                            <div>{{ $order->notes }}</div>
                        </div>
                    @endif
                </div>

                <div class="shipping-section">
                    <h3 class="section-title" style="color: #8fae9e;">&#9873; Informații livrare Sameday</h3>
                    
                    <div class="info-row"><strong>Tip livrare:</strong> 
                        @if($order->delivery_type === 'home')
                            &#9873; Livrare la domiciliu
                        @else
                            &#9633; Livrare la EasyBox
                        @endif
                    </div>

                    <div class="info-row"><strong>Cost livrare:</strong> 
                        @if($order->shipping_cost > 0)
                            <span style="color: #8fae9e; font-weight: bold;">RON {{ number_format($order->shipping_cost, 2) }}</span>
                        @else
                            <span style="color: #047857; font-weight: bold;">GRATUIT</span>
                        @endif
                    </div>

                    @if($order->delivery_type === 'home')
                        <h4 style="margin: 15px 0 10px 0; color: #b01691; font-size: 15px;">&#9872; Adresă livrare:</h4>
                        <div style="padding: 10px; background: #ffffff; border-radius: 6px; line-height: 1.6;">
                            {{ $order->shipping_address }}<br>
                            {{ $order->shipping_city }}@if($order->shipping_postal_code), {{ $order->shipping_postal_code }}@endif<br>
                            {{ $order->shipping_country }}
                        </div>
                    @else
                        <h4 style="margin: 15px 0 10px 0; color: #b01691; font-size: 15px;">&#9633; EasyBox selectat:</h4>
                        <div style="padding: 10px; background: #ffffff; border-radius: 6px;">
                            <strong>{{ $order->sameday_locker_name }}</strong><br>
                            <span style="color: #6b7280;">{{ $order->shipping_city }}</span>
                        </div>
                    @endif

                    @if($order->sameday_county_id && $order->sameday_city_id)
                        <div class="awb-info">
                            <div style="font-size: 14px;">
                                <strong>&#9635; Date pentru creare AWB:</strong><br>
                                Județul și orașul vor fi rezolvate automat de sistem la generarea AWB.
                                @if($order->sameday_locker_id)
                                    <br>Locker ID: {{ $order->sameday_locker_id }}
                                @endif
                            </div>
                        </div>
                    @endif

                    @if($order->sameday_awb_number)
                        <div class="awb-generated">
                            <div style="font-weight: bold; margin-bottom: 5px;">✓ AWB Generat:</div>
                            <div style="font-size: 20px; font-weight: bold; color: #047857; font-family: 'Courier New', monospace;">
                                {{ $order->sameday_awb_number }}
                            </div>
                            @if($order->sameday_awb_cost)
                                <div style="margin-top: 5px; font-size: 14px; color: #6b7280;">
                                    Cost AWB: RON {{ number_format($order->sameday_awb_cost, 2) }}
                                </div>
                            @endif
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
                                <span>&#9888; REDUCERE ({{ $order->coupon->code }}):</span>
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
                            <span>TOTAL COMANDĂ:</span>
                            <span>RON {{ number_format($order->total_amount, 2) }}</span>
                        </div>
                    </div>
                </div>

                <div class="admin-notice">
                    <strong>&#9881; Acțiune necesară:</strong> Accesează panoul admin pentru a gestiona această comandă și a genera AWB
                </div>
            </div>
        </div>
    </div>
</body>
</html>