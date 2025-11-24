<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actualizare comandă</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { padding: 30px 20px; border-radius: 8px; margin-bottom: 20px; text-align: center; color: white; }
        .processing { background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); }
        .completed { background: linear-gradient(135deg, #10b981 0%, #059669 100%); }
        .cancelled { background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%); }
        .order-details { background: #f8f9fa; border-radius: 8px; padding: 20px; margin: 15px 0; }
        .coupon-box { 
            background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
            border: 2px solid #10b981; 
            border-radius: 10px; 
            padding: 15px; 
            margin: 15px 0;
            text-align: center;
        }
        .coupon-code-small {
            font-size: 20px;
            font-weight: bold;
            color: #059669;
            letter-spacing: 1px;
            font-family: 'Courier New', monospace;
        }
        .cancellation-reason { 
            background: #fee2e2; 
            border: 2px solid #fecaca; 
            border-radius: 8px; 
            padding: 15px; 
            margin: 15px 0; 
        }
        .footer { margin-top: 30px; padding-top: 20px; border-top: 1px solid #e5e7eb; color: #6b7280; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header {{ $order->status }}">
            <h1 style="margin: 0 0 10px 0; font-size: 28px;">
                @if($order->status === 'processing')
                    📦 Comandă în procesare
                @elseif($order->status === 'completed')
                    ✅ Comandă finalizată
                @elseif($order->status === 'cancelled')
                    ❌ Comandă anulată
                @endif
            </h1>
            <p style="margin: 0; font-size: 16px;">Comanda #{{ $order->order_number }}</p>
        </div>

        <p style="font-size: 16px;">Bună <strong>{{ $order->shipping_name }}</strong>,</p>
        
        <p>Statusul comenzii tale #{{ $order->order_number }} a fost actualizat:</p>
        
        <div style="background: #f3f4f6; padding: 15px; border-radius: 8px; margin: 15px 0;">
            <p style="margin: 5px 0;"><strong>Status anterior:</strong> <span style="color: #6b7280;">{{ ucfirst($previousStatus) }}</span></p>
            <p style="margin: 5px 0;"><strong>Status curent:</strong> 
                <span style="color: #2563eb; font-weight: bold;">
                    @if($order->status === 'processing')
                        În procesare - comanda ta este pregătită pentru expediere
                    @elseif($order->status === 'completed')
                        Finalizată - comanda a fost livrată cu succes
                    @elseif($order->status === 'cancelled')
                        Anulată - comanda a fost anulată
                    @endif
                </span>
            </p>
        </div>

        @if($order->status === 'cancelled' && $order->cancellation_reason)
            <div class="cancellation-reason">
                <h3 style="margin: 0 0 10px 0; color: #991b1b;">⚠️ Motivul anulării:</h3>
                <p style="margin: 0; color: #7f1d1d;">{{ $order->cancellation_reason }}</p>
            </div>
        @endif

        <div class="order-details">
            <h3 style="margin-top: 0; color: #1f2937;">📋 Detalii comandă:</h3>
            <p style="margin: 8px 0;"><strong>Număr comandă:</strong> {{ $order->order_number }}</p>
            
            @if($order->coupon_id && $order->discount_amount > 0)
                <div class="coupon-box">
                    <p style="margin: 0 0 8px 0; font-size: 14px; color: #059669;">🎉 <strong>Cupon aplicat</strong></p>
                    <div class="coupon-code-small">{{ $order->coupon->code }}</div>
                    <p style="margin: 8px 0 0 0; font-size: 16px; color: #047857; font-weight: bold;">
                        Ai economisit: ${{ number_format($order->discount_amount, 2) }}
                    </p>
                    @if($order->coupon->type === 'percentage')
                        <p style="margin: 5px 0 0 0; font-size: 12px; color: #065f46;">
                            ({{ $order->coupon->value }}% reducere)
                        </p>
                    @endif
                </div>
            @endif
            
            <p style="margin: 8px 0;"><strong>Total:</strong> <span style="color: #2563eb; font-size: 18px; font-weight: bold;">${{ number_format($order->total_amount, 2) }}</span></p>
            <p style="margin: 8px 0;"><strong>Metodă plată:</strong> {{ $order->payment_method === 'card' ? '💳 Card bancar' : '💵 Ramburs la livrare' }}</p>
        </div>

        <div class="footer">
            @if($order->status === 'completed')
                <p style="text-align: center; font-size: 16px; color: #1f2937;">
                    <strong>Mulțumim că ai ales CraftGits Shop! 🙏</strong><br>
                    Sperăm că ești mulțumit de achiziție.
                </p>
            @elseif($order->status === 'cancelled')
                <p style="text-align: center;">
                    Ne pare rău că a trebuit să anulăm comanda.<br>
                    Pentru întrebări, ne poți contacta la: <strong style="color: #2563eb;">contact@craftgits.ro</strong>
                </p>
            @else
                <p style="text-align: center;">
                    Pentru întrebări, ne poți contacta la: <strong style="color: #2563eb;">contact@craftgits.ro</strong>
                </p>
            @endif
        </div>
    </div>
</body>
</html>