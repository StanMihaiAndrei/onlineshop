<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comandă confirmată</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; background: #fff; }
        .header { background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: white; padding: 30px 20px; border-radius: 8px; margin-bottom: 20px; text-align: center; }
        .order-details { background: #f8f9fa; border-radius: 8px; padding: 20px; margin-bottom: 20px; }
        .coupon-highlight { 
            background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
            border: 3px solid #10b981; 
            border-radius: 12px; 
            padding: 20px; 
            margin: 20px 0;
            text-align: center;
            box-shadow: 0 4px 6px rgba(16, 185, 129, 0.1);
        }
        .coupon-code {
            font-size: 28px;
            font-weight: bold;
            color: #059669;
            letter-spacing: 2px;
            margin: 10px 0;
            font-family: 'Courier New', monospace;
        }
        .savings {
            font-size: 24px;
            color: #047857;
            font-weight: bold;
            margin: 10px 0;
        }
        .item { border-bottom: 1px solid #ddd; padding: 10px 0; }
        .item:last-child { border-bottom: none; }
        .total-section { background: #fff; border-radius: 8px; padding: 15px; margin-top: 15px; }
        .subtotal-row { display: flex; justify-content: space-between; margin: 8px 0; }
        .discount-row { 
            display: flex; 
            justify-content: space-between; 
            margin: 8px 0; 
            color: #10b981; 
            font-weight: bold;
            font-size: 16px;
        }
        .total-row { 
            display: flex; 
            justify-content: space-between; 
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
            <h1 style="margin: 0 0 10px 0; font-size: 28px;">✅ Comanda confirmată!</h1>
            <p style="margin: 0; font-size: 16px;">Mulțumim pentru comanda ta #{{ $order->order_number }}</p>
        </div>

        <p style="font-size: 16px;">Bună <strong>{{ $order->shipping_name }}</strong>,</p>
        
        <p>Comanda ta a fost plasată cu succes și va fi procesată în curând. 🎉</p>

        @if($order->coupon_id && $order->discount_amount > 0)
            <div class="coupon-highlight">
                <div style="font-size: 18px; color: #059669; margin-bottom: 10px;">
                    🎊 <strong>Felicitări! Ai aplicat un cupon!</strong> 🎊
                </div>
                <div class="coupon-code">
                    {{ $order->coupon->code }}
                </div>
                <div class="savings">
                    💰 Ai economisit: ${{ number_format($order->discount_amount, 2) }}
                </div>
                <div style="font-size: 14px; color: #047857; margin-top: 10px;">
                    @if($order->coupon->type === 'percentage')
                        ({{ $order->coupon->value }}% reducere aplicată)
                    @else
                        (Reducere fixă aplicată)
                    @endif
                </div>
            </div>
        @endif

        <div class="order-details">
            <h3 style="margin-top: 0; color: #1f2937;">📋 Detalii comandă:</h3>
            <p style="margin: 8px 0;"><strong>Număr comandă:</strong> {{ $order->order_number }}</p>
            <p style="margin: 8px 0;"><strong>Data:</strong> {{ $order->created_at->format('d/m/Y H:i') }}</p>
            <p style="margin: 8px 0;"><strong>Metodă plată:</strong> {{ $order->payment_method === 'card' ? '💳 Card bancar' : '💵 Ramburs la livrare' }}</p>
            <p style="margin: 8px 0;"><strong>Status plată:</strong> 
                <span style="color: {{ $order->payment_status === 'paid' ? '#10b981' : '#f59e0b' }};">
                    {{ $order->payment_status === 'paid' ? '✓ Plătit' : '⏳ În așteptare' }}
                </span>
            </p>

            <h4 style="margin: 20px 0 10px 0; color: #1f2937;">📍 Adresa de livrare:</h4>
            <p style="margin: 5px 0; line-height: 1.6;">
                {{ $order->shipping_address }}<br>
                {{ $order->shipping_city }}, {{ $order->shipping_postal_code }}<br>
                {{ $order->shipping_country }}<br>
                📞 Tel: {{ $order->shipping_phone }}
            </p>
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
                <div class="subtotal-row">
                    <span style="color: #6b7280;">Subtotal produse:</span>
                    <span style="font-weight: 600;">${{ number_format($subtotal, 2) }}</span>
                </div>
                
                @if($order->discount_amount > 0)
                    <div class="discount-row">
                        <span>🎁 Reducere ({{ $order->coupon->code }}):</span>
                        <span>-${{ number_format($order->discount_amount, 2) }}</span>
                    </div>
                @endif
                
                <div class="subtotal-row">
                    <span style="color: #6b7280;">Transport:</span>
                    <span style="color: #10b981; font-weight: 600;">GRATUIT</span>
                </div>
                
                <div class="total-row">
                    <span>Total de plată:</span>
                    <span>${{ number_format($order->total_amount, 2) }}</span>
                </div>
            </div>
        </div>

        <div style="background: #eff6ff; border-left: 4px solid #3b82f6; padding: 15px; border-radius: 4px; margin: 20px 0;">
            <p style="margin: 0; color: #1e40af;">
                <strong>📧 Vei primi un email</strong> cu actualizarea statusului comenzii când aceasta va fi procesată.
            </p>
        </div>

        <div style="margin-top: 30px; padding-top: 20px; border-top: 1px solid #e5e7eb; text-align: center; color: #6b7280;">
            <p>Pentru întrebări, ne poți contacta la: <strong style="color: #2563eb;">contact@craftgits.ro</strong></p>
            <p style="margin-top: 15px; font-size: 16px; color: #1f2937;">
                <strong>Mulțumim că ai ales CraftGits Shop! 🙏</strong>
            </p>
        </div>
    </div>
</body>
</html>