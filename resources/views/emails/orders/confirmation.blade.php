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
        .footer { margin-top: 20px; padding-top: 20px; border-top: 1px solid #ddd; color: #666; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>✅ Comanda trimisă cu succes!</h1>
            <p>Mulțumim pentru comandă!</p>
        </div>

        <p>Bună {{ $order->shipping_name }},</p>
        
        <p>Comanda ta a fost înregistrată cu succes și este în curs de procesare.</p>

        <div class="order-details">
            <h2>Detalii comandă #{{ $order->order_number }}</h2>
            <p><strong>Data comenzii:</strong> {{ $order->created_at->format('d.m.Y H:i') }}</p>
            <p><strong>Metodă de plată:</strong> {{ $order->payment_method === 'card' ? 'Card bancar' : 'Ramburs la livrare' }}</p>
            
            <hr>
            
            <h3>Produse comandate:</h3>
            @foreach($order->items as $item)
                <div class="item">
                    <strong>{{ $item->product_title }}</strong><br>
                    Cantitate: {{ $item->quantity }} × ${{ number_format($item->price, 2) }} = ${{ number_format($item->subtotal, 2) }}
                </div>
            @endforeach
            
            <hr>
            
            <p class="total">Total: ${{ number_format($order->total_amount, 2) }}</p>
            
            <hr>
            
            <h3>Adresa de livrare:</h3>
            <p>{{ $order->shipping_address }}<br>
            {{ $order->shipping_city }}, {{ $order->shipping_postal_code }}<br>
            {{ $order->shipping_country }}</p>
        </div>

        <div class="footer">
            <p>Vei primi un email de confirmare când comanda va fi expediată.</p>
            <p>Pentru întrebări, ne poți contacta la: contact@craftgits.ro</p>
        </div>
    </div>
</body>
</html>