<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actualizare comandă</title>
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
            max-width: 600px; 
            margin: 0 auto; 
            background: #ffffff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        .header { 
            padding: 40px 30px; 
            text-align: center;
            color: white;
        }
        .header.pending { background-color: #f59e0b; }
        .header.processing { background-color: #3b82f6; }
        .header.delivering { background-color: #8b5cf6; }
        .header.completed { background-color: #8fae9e; }
        .header.cancelled { background-color: #ef4444; }
        .header h1 {
            margin: 0 0 10px 0;
            font-size: 28px;
            font-weight: 600;
        }
        .content {
            padding: 30px;
        }
        .greeting {
            font-size: 18px;
            color: #3a3a3a;
            margin-bottom: 20px;
        }
        .status-update {
            background: #f6f1eb;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
            border-left: 4px solid #db1cb5;
        }
        .status-row {
            margin: 10px 0;
        }
        .status-row strong {
            color: #b01691;
        }
        .highlight-box {
            background-color: #e8f4f0;
            border: 2px solid #8fae9e;
            border-radius: 8px;
            padding: 20px;
            margin: 20px 0;
            text-align: center;
        }
        .section {
            background: #f6f1eb;
            border-radius: 8px;
            padding: 20px;
            margin: 20px 0;
            border-left: 4px solid #db1cb5;
        }
        .section-title {
            margin-top: 0;
            color: #b01691;
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 15px;
        }
        .info-row {
            margin: 10px 0;
            color: #3a3a3a;
        }
        .shipping-box {
            background-color: #e8f4f0;
            border: 2px solid #8fae9e;
            border-radius: 8px;
            padding: 20px;
            margin: 20px 0;
        }
        .awb-tracking { 
            background-color: #d5f0e8; 
            border: 2px solid #8fae9e; 
            border-radius: 8px; 
            padding: 20px; 
            margin: 20px 0;
            text-align: center;
        }
        .coupon-box { 
            background-color: #f0d5ea;
            border: 2px solid #db1cb5; 
            border-radius: 10px; 
            padding: 20px; 
            margin: 20px 0;
            text-align: center;
        }
        .coupon-code-small {
            font-size: 22px;
            font-weight: bold;
            color: #b01691;
            letter-spacing: 2px;
            font-family: 'Courier New', monospace;
            padding: 8px;
            background: #ffffff;
            border-radius: 5px;
            display: inline-block;
            margin: 10px 0;
        }
        .cancellation-reason { 
            background-color: #fee2e2; 
            border: 2px solid #fecaca; 
            border-radius: 8px; 
            padding: 15px; 
            margin: 20px 0; 
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
            color: #8fae9e; 
            font-weight: bold;
        }
        .total-row.shipping { 
            color: #db1cb5; 
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
        .info-notice {
            background-color: #f0f9ff;
            border-left: 4px solid #8fae9e;
            padding: 15px;
            border-radius: 4px;
            margin: 20px 0;
        }
        .footer {
            background-color: #f6f1eb;
            padding: 30px;
            text-align: center;
            color: #6b7280;
            font-size: 14px;
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
    </style>
</head>
<body>
    <div class="email-wrapper">
        <div class="container">
            <div class="header {{ $order->status }}">
                <h1>
                    @if($order->status === 'pending')
                        &#9711; Comandă în așteptare
                    @elseif($order->status === 'processing')
                        &#9635; Comandă în procesare
                    @elseif($order->status === 'delivering')
                        &#9873; Comandă în curs de livrare
                    @elseif($order->status === 'completed')
                        &#10004; Comandă finalizată
                    @elseif($order->status === 'cancelled')
                        &#10007; Comandă anulată
                    @endif
                </h1>
                <p>Comanda #{{ $order->order_number }}</p>
            </div>

            <div class="content">
                <p class="greeting">Bună <strong>{{ $order->shipping_name }}</strong>,</p>
                
                <p>Statusul comenzii tale #{{ $order->order_number }} a fost actualizat:</p>
                
                <div class="status-update">
                    <div class="status-row">
                        <strong>Status anterior:</strong> 
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
                    </div>
                    <div class="status-row">
                        <strong>Status curent:</strong> 
                        <span style="color: #db1cb5; font-weight: bold;">
                            @if($order->status === 'pending')
                                &#9711; În așteptare - comanda ta este înregistrată
                            @elseif($order->status === 'processing')
                                &#9635; În procesare - comanda ta este pregătită pentru expediere
                            @elseif($order->status === 'delivering')
                                &#9873; În curs de livrare - coletul tău este pe drum!
                            @elseif($order->status === 'completed')
                                &#10004; Finalizată - comanda a fost livrată cu succes
                            @elseif($order->status === 'cancelled')
                                &#10007; Anulată - comanda a fost anulată
                            @endif
                        </span>
                    </div>
                </div>

                @if($order->status === 'delivering')
                    <div class="highlight-box">
                        <h3 style="margin: 0 0 10px 0; color: #047857; font-size: 22px;">&#9873; Coletul tău este în drum!</h3>
                        <p style="margin: 10px 0; color: #3a3a3a; font-size: 16px;">
                            Comanda ta a fost preluată de curier și va ajunge în curând la tine.
                        </p>
                        @if($order->delivery_type === 'home')
                            <p style="margin: 10px 0; color: #6b7280; font-size: 14px;">
                                &#9872; <strong>Livrare la domiciliu:</strong> {{ $order->shipping_address }}, {{ $order->shipping_city }}
                            </p>
                        @else
                            <p style="margin: 10px 0; color: #6b7280; font-size: 14px;">
                                &#9633; <strong>Livrare la EasyBox:</strong> {{ $order->sameday_locker_name }}, {{ $order->shipping_city }}
                            </p>
                        @endif
                    </div>
                @endif

                @if($order->status === 'cancelled' && $order->cancellation_reason)
                    <div class="cancellation-reason">
                        <h3 style="margin: 0 0 10px 0; color: #991b1b;">&#9888; Motivul anulării:</h3>
                        <p style="margin: 0; color: #7f1d1d;">{{ $order->cancellation_reason }}</p>
                    </div>
                @endif

                @if($order->status !== 'cancelled')
                    <div class="shipping-box">
                        <h3 class="section-title" style="color: #8fae9e;">&#9733; Informații livrare</h3>
                        
                        <div class="info-row"><strong>Tip livrare:</strong> 
                            @if($order->delivery_type === 'home')
                                &#9873; Livrare la domiciliu
                            @else
                                &#9633; Livrare la EasyBox
                            @endif
                        </div>

                        @if($order->delivery_type === 'home')
                            <div class="info-row"><strong>Adresă:</strong><br>
                                {{ $order->shipping_address }}, {{ $order->shipping_city }}
                            </div>
                        @else
                            <div class="info-row"><strong>EasyBox:</strong><br>
                                {{ $order->sameday_locker_name }}, {{ $order->shipping_city }}
                            </div>
                        @endif

                        <div class="info-row"><strong>Cost transport:</strong> 
                            @if($order->shipping_cost > 0)
                                <span style="color: #db1cb5; font-weight: bold;">RON {{ number_format($order->shipping_cost, 2) }}</span>
                            @else
                                <span style="color: #047857; font-weight: bold;">GRATUIT</span>
                            @endif
                        </div>
                    </div>

                    @if($order->sameday_awb_number)
                        <div class="awb-tracking">
                            <h3 style="margin: 0 0 10px 0; color: #047857;">&#9635; Urmărire colet</h3>
                            <p style="margin: 5px 0; font-size: 14px; color: #6b7280;">Număr AWB (Colet):</p>
                            <p style="margin: 10px 0; font-size: 24px; font-weight: bold; color: #047857; font-family: 'Courier New', monospace;">
                                {{ $order->sameday_awb_number }}
                            </p>
                            <p style="margin: 15px 0 5px 0; font-size: 14px; color: #6b7280;">
                                Urmărește coletul aici:<br>
                                <a href="https://sameday.ro/awb-tracking/?awb={{ $order->sameday_awb_number }}" target="_blank" style="color: #8fae9e; font-weight: bold; text-decoration: underline;">
                                    Verifica statusul comenzii
                                </a>
                            </p>
                            
                            @if($order->delivery_type === 'locker')
                                <div style="margin-top: 15px; padding: 10px; background: #fef3c7; border-radius: 6px;">
                                    <p style="margin: 0; font-size: 13px; color: #92400e;">
                                        &#9432; <strong>Pentru EasyBox:</strong> Vei primi SMS/email cu codul de deschidere când coletul ajunge la destinație.
                                    </p>
                                </div>
                            @endif
                        </div>
                    @endif
                @endif

                <div class="section">
                    <h3 class="section-title">&#9679; Detalii comandă</h3>
                    <div class="info-row"><strong>Număr comandă:</strong> {{ $order->order_number }}</div>
                    <div class="info-row"><strong>Data:</strong> {{ $order->created_at->format('d/m/Y H:i') }}</div>
                    
                    @if($order->coupon_id && $order->discount_amount > 0)
                        <div class="coupon-box">
                            <p style="margin: 0 0 8px 0; font-size: 14px; color: #b01691;"><strong>&#9733; Cupon aplicat</strong></p>
                            <div class="coupon-code-small">{{ $order->coupon->code }}</div>
                            <p style="margin: 10px 0 0 0; font-size: 16px; color: #8fae9e; font-weight: bold;">
                                Ai economisit: RON {{ number_format($order->discount_amount, 2) }}
                            </p>
                            @if($order->coupon->type === 'percentage')
                                <p style="margin: 5px 0 0 0; font-size: 12px; color: #6b7280;">
                                    ({{ $order->coupon->value }}% reducere)
                                </p>
                            @endif
                        </div>
                    @endif
                    
                    <div class="total-section">
                        @php
                            $subtotal = 0;
                            foreach($order->items as $item) {
                                $subtotal += $item->subtotal;
                            }
                        @endphp
                        
                        <div class="total-row">
                            <span>Subtotal produse:</span>
                            <span style="font-weight: 600;">RON {{ number_format($subtotal, 2) }}</span>
                        </div>
                        
                        @if($order->discount_amount > 0)
                            <div class="total-row discount">
                                <span>&#9733; Reducere:</span>
                                <span>-RON {{ number_format($order->discount_amount, 2) }}</span>
                            </div>
                        @endif
                        
                        <div class="total-row shipping">
                            <span>&#9873; Transport:</span>
                            <span>
                                @if($order->shipping_cost > 0)
                                    RON {{ number_format($order->shipping_cost, 2) }}
                                @else
                                    GRATUIT
                                @endif
                            </span>
                        </div>
                        
                        <div class="total-row final">
                            <span>Total:</span>
                            <span>RON {{ number_format($order->total_amount, 2) }}</span>
                        </div>
                    </div>

                    <div class="info-row"><strong>Metodă de plată:</strong> {{ $order->payment_method_label }}</div>
                    <div class="info-row">
                        <strong>Status plată:</strong> 
                        <span class="badge {{ $order->payment_status === 'paid' ? 'badge-success' : 'badge-warning' }}">
                            {{ $order->payment_status_label }}
                        </span>
                    </div>
                </div>

                <div class="info-notice">
                    <strong>&#9432; Ai nevoie de ajutor?</strong><br>
                    Dacă ai întrebări despre comanda ta, nu ezita să ne contactezi. Suntem aici să te ajutăm!
                </div>
            </div>

            <div class="footer">
                <p>Mulțumim pentru comanda ta!</p>
                <p style="margin-top: 10px; font-size: 12px; color: #9ca3af;">
                    &copy; {{ date('Y') }} {{ config('app.name') }}. Toate drepturile rezervate.
                </p>
            </div>
        </div>
    </div>
</body>
</html>