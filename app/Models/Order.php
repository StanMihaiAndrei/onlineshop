<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'coupon_id',
        'order_number',
        'total_amount',
        'discount_amount',
        'shipping_cost',
        'status',
        'shipping_name',
        'shipping_email',
        'shipping_phone',
        'shipping_address',
        'shipping_city',
        'shipping_postal_code',
        'shipping_country',
        'is_company',
        'delivery_type',
        'sameday_county_id',
        'sameday_city_id',
        'sameday_locker_id',
        'sameday_locker_name',
        'sameday_awb_number',
        'sameday_awb_cost',
        'sameday_awb_pdf',
        'sameday_awb_status',
        'sameday_tracking_history',
        'payment_method',
        'payment_status',
        'stripe_session_id',
        'notes',
        'cancellation_reason',
    ];

    protected $casts = [
        'is_company' => 'boolean',
        'sameday_tracking_history' => 'array',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($order) {
            $order->order_number = 'ORD-' . strtoupper(uniqid());
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function coupon()
    {
        return $this->belongsTo(Coupon::class);
    }

    /**
     * Check if order has AWB created
     */
    public function hasAwb(): bool
    {
        return !empty($this->sameday_awb_number);
    }

    /**
     * Check if order can have AWB created
     */
    public function canCreateAwb(): bool
    {
        // Verifică dacă AWB-ul nu există deja
        if ($this->hasAwb()) {
            return false;
        }

        // Verifică statusul comenzii
        if (!in_array($this->status, ['pending', 'processing'])) {
            return false;
        }

        // Verifică datele de livrare Sameday
        if (empty($this->sameday_county_id) || empty($this->sameday_city_id)) {
            return false;
        }

        // Pentru plata cu cardul, așteaptă confirmarea plății
        if ($this->payment_method === 'card' && $this->payment_status !== 'paid') {
            return false;
        }

        // Pentru ramburs, nu aștepta plata (se plătește la livrare)
        // Poate fi generat AWB imediat după plasarea comenzii

        return true;
    }

    /**
     * Get total weight of order (kg)
     */
    public function getTotalWeight(): float
    {
        // Calculează greutatea în funcție de produse
        // Pentru simplitate, presupunem 0.5kg per produs
        return $this->items->sum('quantity') * 0.5;
    }
}
