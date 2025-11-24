<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Coupon extends Model
{
    protected $fillable = [
        'code',
        'type',
        'value',
        'valid_from',
        'valid_until',
        'is_active',
        'usage_limit',
        'usage_count',
        'minimum_order_amount',
    ];

    protected $casts = [
        'valid_from' => 'datetime',
        'valid_until' => 'datetime',
        'is_active' => 'boolean',
        'value' => 'decimal:2',
        'minimum_order_amount' => 'decimal:2',
    ];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Verifică dacă cuponul este valid
     */
    public function isValid($orderTotal = null): array
    {
        // Verifică dacă este activ
        if (!$this->is_active) {
            return ['valid' => false, 'message' => 'This coupon is no longer active.'];
        }

        // Verifică data de început
        if ($this->valid_from && Carbon::now()->lt($this->valid_from)) {
            return ['valid' => false, 'message' => 'This coupon is not yet valid.'];
        }

        // Verifică data de expirare
        if ($this->valid_until && Carbon::now()->gt($this->valid_until)) {
            return ['valid' => false, 'message' => 'This coupon has expired.'];
        }

        // Verifică limita de utilizări
        if ($this->usage_limit && $this->usage_count >= $this->usage_limit) {
            return ['valid' => false, 'message' => 'This coupon has reached its usage limit.'];
        }

        // Verifică suma minimă a comenzii
        if ($this->minimum_order_amount && $orderTotal < $this->minimum_order_amount) {
            return ['valid' => false, 'message' => "Minimum order amount is $" . number_format($this->minimum_order_amount, 2)];
        }

        return ['valid' => true, 'message' => 'Coupon applied successfully!'];
    }

    /**
     * Calculează discount-ul
     */
    public function calculateDiscount($orderTotal): float
    {
        if ($this->type === 'percentage') {
            $discount = ($orderTotal * $this->value) / 100;
        } else {
            $discount = $this->value;
        }

        // Discount-ul nu poate fi mai mare decât totalul comenzii
        return min($discount, $orderTotal);
    }

    /**
     * Incrementează numărul de utilizări
     */
    public function incrementUsage()
    {
        $this->increment('usage_count');
    }
}