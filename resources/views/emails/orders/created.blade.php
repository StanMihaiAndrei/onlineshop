<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comandă nouă</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; background: #fff; }
        .header { background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); color: white; padding: 30px 20px; border-radius: 8px; margin-bottom: 20px; text-align: center; }
        .order-details { background: #f8f9fa; border: 1px solid #e5e7eb; border-radius: 8px; padding: 20px; margin-bottom: 15px; }
        .shipping-section { background: #dbeafe; border: 2px solid #3b82f6; border-radius: 8px; padding: 20px; margin-bottom: 15px; }
        .coupon-admin { 
            background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
            border: 3px solid #f59e0b; 
            border-radius: 12px; 
            padding: 20px; 
            margin: 20px 0;
            text-align: center;
        }
        .coupon-code-admin {
            font-size: 24px;
            font-weight: bold;
            color: #d97706;
            letter-spacing: 2px;
            margin: 10px 0;
            font-family: 'Courier New', monospace;
        }
        .item { border-bottom: 1px solid #e5e7eb; padding: 10px 0; }
        .item:last-child { border-bottom: none; }
        .total-section { background: #fff; border-radius: 8px; padding: 15px; margin-top: 15px; }
        .discount-row { 
            color: #f59e0b; 
            font-weight: bold;
            font-size: 16px;
            margin: 8px 0;
        }
        .shipping-row { 
            color: #3b82f6; 
            font-weight: 600;
            font-size: 16px;
            margin: 8px 0;
        }
        .total-row { 
            margin-top: 15px; 
            padding-top: 15px; 
            border-top: 2px solid #ddd;
            font-size: 20px;
            font-weight: bold;
            color: #2563eb;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1 style="margin: 0 0 10px 0; font-size: 28px;">🎉 Comandă nouă pe site!</h1>
            <p style="margin: 0; font-size: 16px;">O comandă nouă a fost plasată pe CraftGits Shop</p>
        </div>

        @if($order->coupon_id && $order->discount_amount > 0)
            <div class="coupon-admin">
                <div style="font-size: 18px; color: #d97706; margin-bottom: 10px;">
                    ⚠️ <strong>ATENȚIE: Cupon aplicat!</strong> ⚠️
                </div>
                <div class="coupon-code-admin">
                    {{ $order->coupon->code }}
                </div>
                <div style="font-size: 22px; color: #b45309; font-weight: bold; margin: 10px 0;">
                    💰 Reducere: ${{ number_format($order->discount_amount, 2) }}
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

        <div class="order-details">
            <h2 style="margin-top: 0; color: #1f2937; font-size: 20px;">📋 Detalii comandă #{{ $order->order_number }}</h2>
            
            <div style="background: #fff; padding: 15px; border-radius: 6px; margin: 15px 0;">
                <h3 style="margin: 0 0 10px 0; color: #374151; font-size: 16px;">👤 Informații client:</h3>
                <p style="margin: 5px 0;"><strong>Nume:</strong> {{ $order->shipping_name }}</p>
                <p style="margin: 5px 0;"><strong>Email:</strong> <a href="mailto:{{ $order->shipping_email }}" style="color: #2563eb;">{{ $order->shipping_email }}</a></p>
                <p style="margin: 5px 0;"><strong>Telefon:</strong> <a href="tel:{{ $order->shipping_phone }}" style="color: #2563eb;">{{ $order->shipping_phone }}</a></p>
                @if($order->is_company)
                    <p style="margin: 5px 0; color: #f59e0b;"><strong>⚠️ FIRMĂ</strong></p>
                @endif
            </div>

            <div style="background: #fff; padding: 15px; border-radius: 6px; margin: 15px 0;">
                <h3 style="margin: 0 0 10px 0; color: #374151; font-size: 16px;">💳 Informații plată:</h3>
                <p style="margin: 5px 0;"><strong>Metodă:</strong> {{ $order->payment_method === 'card' ? '💳 Card bancar' : '💵 Ramburs' }}</p>
                <p style="margin: 5px 0;"><strong>Status:</strong> 
                    <span style="color: {{ $order->payment_status === 'paid' ? '#10b981' : '#f59e0b' }}; font-weight: bold;">
                        {{ $order->payment_status === 'paid' ? '✓ PLĂTIT' : '⏳ ÎN AȘTEPTARE' }}
                    </span>
                </p>
            </div>
            
            @if($order->notes)
                <div style="background: #fef3c7; border-left: 4px solid #f59e0b; padding: 15px; border-radius: 4px; margin: 15px 0;">
                    <p style="margin: 0;"><strong>📝 Note comandă:</strong></p>
                    <p style="margin: 5px 0 0 0;">{{ $order->notes }}</p>
                </div>
            @endif
        </div>

        <!-- Shipping Section -->
        <div class="shipping-section">
            <h3 style="margin-top: 0; color: #1e40af;">🚚 Informații livrare Sameday</h3>
            
            <p style="margin: 8px 0;"><strong>Tip livrare:</strong> 
                @if($order->delivery_type === 'home')
                    🏠 <strong style="color: #2563eb;">Livrare la domiciliu</strong>
                @else
                    📦 <strong style="color: #2563eb;">Livrare la EasyBox</strong>
                @endif
            </p>

            <p style="margin: 8px 0;"><strong>Cost livrare:</strong> 
                @if($order->shipping_cost > 0)
                    <span style="color: #2563eb; font-weight: bold;">${{ number_format($order->shipping_cost, 2) }}</span>
                @else
                    <span style="color: #10b981; font-weight: bold;">GRATUIT</span>
                @endif
            </p>

            @if($order->delivery_type === 'home')
                <h4 style="margin: 15px 0 10px 0; color: #1f2937; font-size: 15px;">📍 Adresă livrare:</h4>
                <p style="margin: 5px 0; line-height: 1.6; background: #fff; padding: 10px; border-radius: 6px;">
                    {{ $order->shipping_address }}<br>
                    {{ $order->shipping_city }}@if($order->shipping_postal_code), {{ $order->shipping_postal_code }}@endif<br>
                    {{ $order->shipping_country }}
                </p>
            @else
                <h4 style="margin: 15px 0 10px 0; color: #1f2937; font-size: 15px;">📦 EasyBox selectat:</h4>
                <p style="margin: 5px 0; background: #fff; padding: 10px; border-radius: 6px;">
                    <strong>{{ $order->sameday_locker_name }}</strong><br>
                    <span style="color: #6b7280;">{{ $order->shipping_city }}</span>
                </p>
            @endif

            @if($order->sameday_county_id && $order->sameday_city_id)
                <div style="margin-top: 15px; padding: 10px; background: #fef3c7; border-radius: 6px;">
                    <p style="margin: 0; font-size: 14px;">
                        <strong>📌 Creare AWB:</strong> Judet ID: {{ $order->sameday_county_id }}, Oras ID: {{ $order->sameday_city_id }}
                        @if($order->sameday_locker_id)
                            , Locker ID: {{ $order->sameday_locker_id }}
                        @endif
                    </p>
                </div>
            @endif

            @if($order->sameday_awb_number)
                <div style="margin-top: 15px; padding: 15px; background: #d1fae5; border: 2px solid #10b981; border-radius: 8px;">
                    <p style="margin: 0;"><strong>✅ AWB Generat:</strong></p>
                    <p style="margin: 5px 0; font-size: 20px; font-weight: bold; color: #059669;">
                        {{ $order->sameday_awb_number }}
                    </p>
                    @if($order->sameday_awb_cost)
                        <p style="margin: 5px 0; font-size: 14px; color: #047857;">
                            Cost AWB: ${{ number_format($order->sameday_awb_cost, 2) }}
                        </p>
                    @endif
                </div>
            @else
                <div style="margin-top: 15px; padding: 10px; background: #fee2e2; border-radius: 6px;">
                    <p style="margin: 0; font-size: 14px; color: #991b1b;">
                        ⚠️ AWB încă negenerat. Creează AWB din panoul admin.
                    </p>
                </div>
            @endif
        </div>

        <div class="order-details">
            <h3 style="margin-top: 0; color: #1f2937;">🛍️ Produse comandate:</h3>
            
            @php
                $subtotal = 0;
            @endphp
            @foreach($order->items as $item)
                @php
                    $subtotal += $item->subtotal;
                @endphp
                <div class="item">
                    <strong style="color: #1f2937; font-size: 15px;">{{ $item->product_title }}</strong><br>
                    <span style="color: #6b7280; font-size: 14px;">
                        Cantitate: {{ $item->quantity }} × ${{ number_format($item->price, 2) }} = 
                        <strong style="color: #1f2937;">${{ number_format($item->subtotal, 2) }}</strong>
                    </span>
                </div>
            @endforeach
            
            <div class="total-section">
                <div style="display: flex; justify-content: space-between; margin: 8px 0;">
                    <span style="color: #6b7280;">Subtotal produse:</span>
                    <span style="font-weight: 600;">${{ number_format($subtotal, 2) }}</span>
                </div>
                
                @if($order->discount_amount > 0)
                    <div class="discount-row" style="display: flex; justify-content: space-between;">
                        <span>⚠️ REDUCERE ({{ $order->coupon->code }}):</span>
                        <span>-${{ number_format($order->discount_amount, 2) }}</span>
                    </div>
                @endif
                
                <div class="shipping-row" style="display: flex; justify-content: space-between;">
                    <span>🚚 Transport ({{ $order->delivery_type === 'home' ? 'Domiciliu' : 'EasyBox' }}):</span>
                    <span>
                        @if($order->shipping_cost > 0)
                            ${{ number_format($order->shipping_cost, 2) }}
                        @else
                            GRATUIT
                        @endif
                    </span>
                </div>
                
                <div class="total-row" style="display: flex; justify-content: space-between;">
                    <span>TOTAL COMANDĂ:</span>
                    <span>${{ number_format($order->total_amount, 2) }}</span>
                </div>
            </div>
        </div>

        <div style="background: #dbeafe; border-left: 4px solid #3b82f6; padding: 15px; border-radius: 4px; margin: 20px 0; text-align: center;">
            <p style="margin: 0; color: #1e40af; font-weight: bold;">
                🔔 Accesează panoul admin pentru a gestiona această comandă și a genera AWB
            </p>
        </div>
    </div>
</body>
</html>