<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comandă nouă</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: #f8f9fa; padding: 20px; border-radius: 8px; margin-bottom: 20px; }
        .order-details { background: #fff; border: 1px solid #ddd; border-radius: 8px; padding: 20px; }
        .item { border-bottom: 1px solid #eee; padding: 10px 0; }
        .item:last-child { border-bottom: none; }
        .total { font-weight: bold; font-size: 18px; color: #2563eb; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🎉 Comandă nouă pe site!</h1>
            <p>O comandă nouă a fost plasată pe CraftGits Shop</p>
        </div>

        <div class="order-details">
            <h2>Detalii comandă #{{ $order->order_number }}</h2>
            
            <p><strong>Client:</strong> {{ $order->shipping_name }}</p>
            <p><strong>Email:</strong> {{ $order->shipping_email }}</p>
            <p><strong>Telefon:</strong> {{ $order->shipping_phone }}</p>
            <p><strong>Adresa:</strong> {{ $order->shipping_address }}, {{ $order->shipping_city }}, {{ $order->shipping_postal_code }}, {{ $order->shipping_country }}</p>
            <p><strong>Metodă plată:</strong> {{ $order->payment_method === 'card' ? 'Card bancar' : 'Ramburs la livrare' }}</p>
            <p><strong>Status plată:</strong> {{ $order->payment_status === 'paid' ? 'Plătit' : 'În așteptare' }}</p>
            
            @if($order->notes)
                <p><strong>Note:</strong> {{ $order->notes }}</p>
            @endif

            <h3>Produse comandate:</h3>
            @foreach($order->items as $item)
                <div class="item">
                    <strong>{{ $item->product_title }}</strong><br>
                    Cantitate: {{ $item->quantity }} × ${{ number_format($item->price, 2) }} = ${{ number_format($item->subtotal, 2) }}
                </div>
            @endforeach
            
            <div class="total">
                Total comandă: ${{ number_format($order->total_amount, 2) }}
            </div>
        </div>

        <p>Accesează panoul admin pentru a gestiona această comandă.</p>
    </div>
</body>
</html>