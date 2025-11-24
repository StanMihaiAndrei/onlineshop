<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actualizare comandă</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { padding: 20px; border-radius: 8px; margin-bottom: 20px; text-align: center; }
        .processing { background: #3b82f6; color: white; }
        .completed { background: #10b981; color: white; }
        .cancelled { background: #ef4444; color: white; }
        .order-details { background: #f8f9fa; border-radius: 8px; padding: 20px; }
        .coupon-box { background: #d1fae5; border: 1px solid #10b981; border-radius: 8px; padding: 10px; margin: 10px 0; }
        .cancellation-reason { background: #fee2e2; border: 1px solid #fecaca; border-radius: 8px; padding: 15px; margin: 15px 0; }
        .footer { margin-top: 20px; padding-top: 20px; border-top: 1px solid #ddd; color: #666; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header {{ $order->status }}">
            <h1>
                @if($order->status === 'processing')
                    📦 Comanda ta este în procesare
                @elseif($order->status === 'completed')
                    ✅ Comanda ta a fost finalizată
                @elseif($order->status === 'cancelled')
                    ❌ Comanda ta a fost anulată
                @endif
            </h1>
        </div>

        <p>Bună {{ $order->shipping_name }},</p>
        
        <p>Statusul comenzii tale #{{ $order->order_number }} a fost actualizat:</p>
        
        <p><strong>Status anterior:</strong> {{ ucfirst($previousStatus) }}</p>
        <p><strong>Status curent:</strong> 
            @if($order->status === 'processing')
                În procesare - comanda ta este pregătită pentru expediere
            @elseif($order->status === 'completed')
                Finalizată - comanda a fost livrată cu succes
            @elseif($order->status === 'cancelled')
                Anulată - comanda a fost anulată
            @endif
        </p>

        @if($order->status === 'cancelled' && $order->cancellation_reason)
            <div class="cancellation-reason">
                <h3>Motivul anulării:</h3>
                <p>{{ $order->cancellation_reason }}</p>
            </div>
        @endif

        <div class="order-details">
            <h3>Detalii comandă:</h3>
            <p><strong>Număr comandă:</strong> {{ $order->order_number }}</p>
            
            @if($order->coupon_id && $order->discount_amount > 0)
                <div class="coupon-box">
                    <p style="margin: 0;"><strong>🎉 Cupon aplicat:</strong> {{ $order->coupon->code }}</p>
                    <p style="margin: 5px 0 0 0; font-size: 14px; color: #059669;">
                        Ai economisit ${{ number_format($order->discount_amount, 2) }}
                    </p>
                </div>
            @endif
            
            <p><strong>Total:</strong> ${{ number_format($order->total_amount, 2) }}</p>
            <p><strong>Metodă plată:</strong> {{ $order->payment_method === 'card' ? 'Card bancar' : 'Ramburs la livrare' }}</p>
        </div>

        <div class="footer">
            @if($order->status === 'completed')
                <p>Mulțumim că ai ales CraftGits Shop! Sperăm că ești mulțumit de achiziție.</p>
            @elseif($order->status === 'cancelled')
                <p>Ne pare rău că a trebuit să anulăm comanda. Pentru întrebări, ne poți contacta.</p>
            @endif
            <p>Pentru întrebări, ne poți contacta la: contact@craftgits.ro</p>
        </div>
    </div>
</body>
</html>