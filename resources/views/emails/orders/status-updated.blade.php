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
        .pending { background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); }
        .processing { background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); }
        .delivering { background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%); }
        .completed { background: linear-gradient(135deg, #10b981 0%, #059669 100%); }
        .cancelled { background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%); }
        .order-details { background: #f8f9fa; border-radius: 8px; padding: 20px; margin: 15px 0; }
        .shipping-box { background: #dbeafe; border: 2px solid #3b82f6; border-radius: 8px; padding: 15px; margin: 15px 0; }
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
        .awb-tracking { 
            background: #d1fae5; 
            border: 2px solid #10b981; 
            border-radius: 8px; 
            padding: 15px; 
            margin: 15px 0;
            text-align: center;
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
                @if($order->status === 'pending')
                    ⏳ Comandă în așteptare
                @elseif($order->status === 'processing')
                    📦 Comandă în procesare
                @elseif($order->status === 'delivering')
                    🚚 Comandă în curs de livrare
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
            <p style="margin: 5px 0;"><strong>Status anterior:</strong> 
                <span style="color: #6b7280;">
                    @php
                        $prevLabel = match($previousStatus) {
                            'pending' => 'În așteptare',
                            'processing' => 'În procesare',
                            'delivering' => 'În curs de livrare',
                            'completed' => 'Finalizată',
                            'cancelled' => 'Anulată',
                            default => ucfirst($previousStatus)
                        };
                    @endphp
                    {{ $prevLabel }}
                </span>
            </p>
            <p style="margin: 5px 0;"><strong>Status curent:</strong> 
                <span style="color: #2563eb; font-weight: bold;">
                    @if($order->status === 'pending')
                        ⏳ În așteptare - comanda ta este înregistrată
                    @elseif($order->status === 'processing')
                        📦 În procesare - comanda ta este pregătită pentru expediere
                    @elseif($order->status === 'delivering')
                        🚚 În curs de livrare - coletul tău este pe drum!
                    @elseif($order->status === 'completed')
                        ✅ Finalizată - comanda a fost livrată cu succes
                    @elseif($order->status === 'cancelled')
                        ❌ Anulată - comanda a fost anulată
                    @endif
                </span>
            </p>
        </div>

        @if($order->status === 'delivering')
            <div style="background: linear-gradient(135deg, #ede9fe 0%, #ddd6fe 100%); border: 2px solid #8b5cf6; border-radius: 8px; padding: 20px; margin: 20px 0; text-align: center;">
                <h3 style="margin: 0 0 10px 0; color: #6b21a8; font-size: 22px;">🚚 Coletul tău este în drum!</h3>
                <p style="margin: 10px 0; color: #5b21b6; font-size: 16px;">
                    Comanda ta a fost preluată de curier și va ajunge în curând la tine.
                </p>
                @if($order->delivery_type === 'home')
                    <p style="margin: 10px 0; color: #6b21a8; font-size: 14px;">
                        📍 <strong>Livrare la domiciliu:</strong> {{ $order->shipping_address }}, {{ $order->shipping_city }}
                    </p>
                @else
                    <p style="margin: 10px 0; color: #6b21a8; font-size: 14px;">
                        📦 <strong>Livrare la EasyBox:</strong> {{ $order->sameday_locker_name }}, {{ $order->shipping_city }}
                    </p>
                @endif
            </div>
        @endif

        @if($order->status === 'cancelled' && $order->cancellation_reason)
            <div class="cancellation-reason">
                <h3 style="margin: 0 0 10px 0; color: #991b1b;">⚠️ Motivul anulării:</h3>
                <p style="margin: 0; color: #7f1d1d;">{{ $order->cancellation_reason }}</p>
            </div>
        @endif

        <!-- Shipping Info -->
        @if($order->status !== 'cancelled')
            <div class="shipping-box">
                <h3 style="margin-top: 0; color: #1e40af;">🚚 Informații livrare</h3>
                
                <p style="margin: 8px 0;"><strong>Tip livrare:</strong> 
                    @if($order->delivery_type === 'home')
                        🏠 Livrare la domiciliu
                    @else
                        📦 Livrare la EasyBox
                    @endif
                </p>

                @if($order->delivery_type === 'home')
                    <p style="margin: 8px 0;"><strong>Adresă:</strong><br>
                        {{ $order->shipping_address }}, {{ $order->shipping_city }}
                    </p>
                @else
                    <p style="margin: 8px 0;"><strong>EasyBox:</strong><br>
                        {{ $order->sameday_locker_name }}, {{ $order->shipping_city }}
                    </p>
                @endif

                <p style="margin: 8px 0;"><strong>Cost transport:</strong> 
                    @if($order->shipping_cost > 0)
                        <span style="color: #2563eb; font-weight: bold;">RON {{ number_format($order->shipping_cost, 2) }}</span>
                    @else
                        <span style="color: #10b981; font-weight: bold;">GRATUIT</span>
                    @endif
                </p>
            </div>

            @if($order->sameday_awb_number)
                <div class="awb-tracking">
                    <h3 style="margin: 0 0 10px 0; color: #059669;">📦 Urmărire colet</h3>
                    <p style="margin: 5px 0; font-size: 14px; color: #047857;">Număr AWB (Colet):</p>
                    <p style="margin: 5px 0; font-size: 24px; font-weight: bold; color: #059669; font-family: 'Courier New', monospace;">
                        {{ $order->sameday_awb_number }}
                    </p>
                    <p style="margin: 15px 0 5px 0; font-size: 14px; color: #047857;">
                        Urmărește coletul aici:<br>
                        <a href="https://sameday.ro/tracking" style="color: #059669; font-weight: bold; text-decoration: underline;">
                            sameday.ro/tracking
                        </a>
                    </p>
                    
                    @if($order->delivery_type === 'locker')
                        <div style="margin-top: 15px; padding: 10px; background: #fef3c7; border-radius: 6px;">
                            <p style="margin: 0; font-size: 13px; color: #92400e;">
                                💡 <strong>Pentru EasyBox:</strong> Vei primi SMS/email cu codul de deschidere când coletul ajunge la destinație.
                            </p>
                        </div>
                    @endif
                </div>
            @endif
        @endif

        <div class="order-details">
            <h3 style="margin-top: 0; color: #1f2937;">📋 Detalii comandă:</h3>
            <p style="margin: 8px 0;"><strong>Număr comandă:</strong> {{ $order->order_number }}</p>
            <p style="margin: 8px 0;"><strong>Data:</strong> {{ $order->created_at->format('d/m/Y H:i') }}</p>
            
            @if($order->coupon_id && $order->discount_amount > 0)
                <div class="coupon-box">
                    <p style="margin: 0 0 8px 0; font-size: 14px; color: #059669;">🎉 <strong>Cupon aplicat</strong></p>
                    <div class="coupon-code-small">{{ $order->coupon->code }}</div>
                    <p style="margin: 8px 0 0 0; font-size: 16px; color: #047857; font-weight: bold;">
                        Ai economisit: RON {{ number_format($order->discount_amount, 2) }}
                    </p>
                    @if($order->coupon->type === 'percentage')
                        <p style="margin: 5px 0 0 0; font-size: 12px; color: #065f46;">
                            ({{ $order->coupon->value }}% reducere)
                        </p>
                    @endif
                </div>
            @endif
            
            <div style="background: #fff; padding: 15px; border-radius: 8px; margin-top: 15px;">
                @php
                    $subtotal = 0;
                    foreach($order->items as $item) {
                        $subtotal += $item->subtotal;
                    }
                @endphp
                
                <div style="display: flex; justify-content: space-between; margin: 8px 0;">
                    <span style="color: #6b7280;">Subtotal produse:</span>
                    <span style="font-weight: 600;">RON {{ number_format($subtotal, 2) }}</span>
                </div>
                
                @if($order->discount_amount > 0)
                    <div style="display: flex; justify-content: space-between; margin: 8px 0; color: #10b981; font-weight: bold;">
                        <span>🎁 Reducere:</span>
                        <span>-RON {{ number_format($order->discount_amount, 2) }}</span>
                    </div>
                @endif
                
                <div style="display: flex; justify-content: space-between; margin: 8px 0; color: #3b82f6; font-weight: 600;">
                    <span>🚚 Transport:</span>
                    <span>
                        @if($order->shipping_cost > 0)
                            RON {{ number_format($order->shipping_cost, 2) }}
                        @else
                            GRATUIT
                        @endif
                    </span>
                </div>
                
                <div style="display: flex; justify-content: space-between; margin-top: 15px; padding-top: 15px; border-top: 2px solid #ddd; font-size: 20px; font-weight: bold; color: #2563eb;">
                    <span>Total:</span>
                    <span>RON {{ number_format($order->total_amount, 2) }}</span>
                </div>
            </div>

            <p style="margin: 8px 0;"><strong>Metodă de plată:</strong> {{ $order->payment_method_label }}</p>
            <p style="margin: 8px 0;"><strong>Status plată:</strong> 
                <span style="color: {{ $order->payment_status === 'paid' ? '#10b981' : '#f59e0b' }}; font-weight: bold;">
                    {{ $order->payment_status_label }}
                </span>
            </p>
        </div>

        <div style="background: #eff6ff; border-left: 4px solid #3b82f6; padding: 15px; margin: 20px 0; border-radius: 4px;">
            <p style="margin: 0; color: #1e40af;">
                <strong>💡 Ai nevoie de ajutor?</strong><br>
                Dacă ai întrebări despre comanda ta, nu ezita să ne contactezi. Suntem aici să te ajutăm!
            </p>
        </div>

        <div class="footer">
            <p style="margin: 5px 0; font-size: 14px;">Mulțumim pentru comanda ta! 🎉</p>
            <p style="margin: 5px 0; font-size: 12px;">© {{ date('Y') }} {{ config('app.name') }}. Toate drepturile rezervate.</p>
        </div>
    </div>
</body>
</html>