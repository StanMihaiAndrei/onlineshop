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
        .item { border-bottom: 1px solid #ddd; padding: 10px 0; }
        .item:last-child { border-bottom: none; }
        .total { font-weight: bold; font-size: 18px; color: #2563eb; }
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
            @foreach($order->items as $item)
                <div class="item">
                    <strong>{{ $item->product_title }}</strong><br>
                    Cantitate: {{ $item->quantity }} × ${{ number_format($item->price, 2) }} = ${{ number_format($item->subtotal, 2) }}
                </div>
            @endforeach
            
            <div class="total">
                Total: ${{ number_format($order->total_amount, 2) }}
            </div>
        </div>

        <p>Vei primi un email cu actualizarea statusului comenzii când aceasta va fi procesată.</p>
        
        <p>Pentru întrebări, ne poți contacta la: contact@craftgits.ro</p>
        
        <p>Mulțumim că ai ales CraftGits Shop!</p>
    </div>
</body>
</html>