<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comandă confirmată</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: #10b981; color: white; padding: 20px; border-radius: 8px; margin-bottom: 20px; text-align: center; }
        .order-details { background: #f8f9fa; border-radius: 8px; padding: 20px; }
        .coupon-box { background: #d1fae5; border: 2px solid #10b981; border-radius: 8px; padding: 15px; margin: 15px 0; }
        .item { border-bottom: 1px solid #ddd; padding: 10px 0; }
        .item:last-child { border-bottom: none; }
        .total { font-weight: bold; font-size: 18px; color: #2563eb; }
        .discount { color: #10b981; font-weight: bold; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>✅ Comanda ta a fost confirmată!</h1>
            <p>Mulțumim pentru comanda ta #{{ $order->order_number }}</p>
        </div>

        <p>Bună {{ $order->shipping_name }},</p>
        
        <p>Comanda ta a fost plasată cu succes și va fi procesată în curând.</p>

        @if($order->coupon_id && $order->discount_amount > 0)
            <div class="coupon-box">
                <p style="margin: 0; font-size: 18px;">🎉 <strong>Cupon aplicat: {{ $order->coupon->code }}</strong></p>
                <p style="margin: 5px 0 0 0; color: #059669;">
                    Ai economisit: ${{ number_format($order->discount_amount, 2) }}
                    @if($order->coupon->type === 'percentage')
                        ({{ $order->coupon->value }}% reducere)
                    @endif
                </p>
            </div>
        @endif

        <div class="order-details">
            <h3>Detalii comandă:</h3>
            <p><strong>Număr comandă:</strong> {{ $order->order_number }}</p>
            <p><strong>Data:</strong> {{ $order->created_at->format('d/m/Y H:i') }}</p>
            <p><strong>Metodă plată:</strong> {{ $order->payment_method === 'card' ? 'Card bancar' : 'Ramburs la livrare' }}</p>
            <p><strong>Status plată:</strong> {{ $order->payment_status === 'paid' ? 'Plătit' : 'În așteptare' }}</p>

            <h4>Adresa de livrare:</h4>
            <p>{{ $order->shipping_address }}<br>
            {{ $order->shipping_city }}, {{ $order->shipping_postal_code }}<br>
            {{ $order->shipping_country }}<br>
            Tel: {{ $order->shipping_phone }}</p>

            <h4>Produse comandate:</h4>
            @php
                $subtotal = 0;
            @endphp
            @foreach($order->items as $item)
                @php
                    $subtotal += $item->subtotal;
                @endphp
                <div class="item">
                    <strong>{{ $item->product_title }}</strong><br>
                    Cantitate: {{ $item->quantity }} × ${{ number_format($item->price, 2) }} = ${{ number_format($item->subtotal, 2) }}
                </div>
            @endforeach
            
            <div style="margin-top: 15px; padding-top: 15px; border-top: 2px solid #ddd;">
                <p style="margin: 5px 0;"><strong>Subtotal:</strong> ${{ number_format($subtotal, 2) }}</p>
                
                @if($order->discount_amount > 0)
                    <p style="margin: 5px 0;" class="discount">
                        <strong>Reducere ({{ $order->coupon->code }}):</strong> -${{ number_format($order->discount_amount, 2) }}
                    </p>
                @endif
                
                <p style="margin: 5px 0;"><strong>Transport:</strong> GRATUIT</p>
                
                <div class="total" style="margin-top: 10px; padding-top: 10px; border-top: 2px solid #ddd;">
                    Total de plată: ${{ number_format($order->total_amount, 2) }}
                </div>
            </div>
        </div>

        <p>Vei primi un email cu actualizarea statusului comenzii când aceasta va fi procesată.</p>
        
        <p>Pentru întrebări, ne poți contacta la: contact@craftgits.ro</p>
        
        <p>Mulțumim că ai ales CraftGits Shop!</p>
    </div>
</body>
</html>