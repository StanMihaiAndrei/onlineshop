<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;
use App\Models\Review;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'price',
        'discount_price',
        'images',
        'is_active',
        'stock',
        'width',
        'height',
        'length',
    ];

    protected $casts = [
        'images' => 'array',
        'price' => 'decimal:2',
        'is_active' => 'boolean',
        'width' => 'decimal:2',
        'height' => 'decimal:2',
        'length' => 'decimal:2',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($product) {
            if (empty($product->slug)) {
                $product->slug = Str::slug($product->title);
            }
        });

        static::updating(function ($product) {
            if ($product->isDirty('title')) {
                $product->slug = Str::slug($product->title);
            }
        });
    }

    public function getFirstImageAttribute()
    {
        return $this->images[0] ?? null;
    }

    public function colors(): BelongsToMany
    {
        return $this->belongsToMany(Color::class);
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function approvedReviews()
    {
        return $this->hasMany(Review::class)->where('is_approved', true);
    }

    public function getFinalPriceAttribute()
    {
        return $this->discount_price > 0 ? $this->discount_price : $this->price;
    }

    public function hasDiscount()
    {
        return $this->discount_price > 0 && $this->discount_price < $this->price;
    }

    public function getDiscountPercentageAttribute()
    {
        if (!$this->hasDiscount()) {
            return 0;
        }
        return round((($this->price - $this->discount_price) / $this->price) * 100);
    }

    public function getDimensionsAttribute()
    {
        if ($this->width && $this->height && $this->length) {
            return "{$this->width} × {$this->height} × {$this->length} cm";
        }
        return null;
    }

    /**
     * Calculează rating-ul produsului folosind un algoritm care avantajează produsul
     * Formula: Media ponderată care tinde către 5 stele
     * Exemplu: 5 + 4 = 4.8 (în loc de 4.5)
     */
    public function getAverageRatingAttribute()
    {
        $reviews = $this->approvedReviews;

        if ($reviews->count() === 0) {
            return 0;
        }

        // Algoritmul optimist: (suma + număr_reviews * bonus) / (număr_reviews + bonus_weight)
        // Bonus-ul adaugă "review-uri implicite" de 5 stele pentru a avantaja produsul
        $totalRating = $reviews->sum('rating');
        $reviewCount = $reviews->count();

        // Parametrii algoritmului optimist
        $bonusStars = 5; // Stelele implicite pentru bonus
        $bonusWeight = 1; // Câte "review-uri bonus" adăugăm (scade pe măsură ce crește numărul de review-uri reale)

        // Formula optimistă
        $optimisticRating = ($totalRating + ($bonusStars * $bonusWeight)) / ($reviewCount + $bonusWeight);

        return round($optimisticRating, 1);
    }

    /**
     * Returnează numărul total de review-uri aprobate
     */
    public function getReviewsCountAttribute()
    {
        // Verifică dacă avem deja count-ul încărcat din query (mai rapid)
        if (array_key_exists('approved_reviews_count', $this->attributes)) {
            return $this->attributes['approved_reviews_count'];
        }

        // Altfel, calculează manual (mai lent dar funcțional)
        return $this->approvedReviews()->count();
    }

    /**
     * Returnează distribuția stelelor (câte review-uri pentru fiecare nivel de rating)
     */
    public function getRatingDistributionAttribute()
    {
        // Folosește relația deja încărcată dacă există, altfel face query
        $reviews = $this->relationLoaded('approvedReviews')
            ? $this->approvedReviews
            : $this->approvedReviews()->get();

        // Inițializează array-ul cu toate valorile de la 1 la 5
        $distribution = [1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0];

        // Grupează review-urile după rating și actualizează array-ul
        foreach ($reviews as $review) {
            $rating = (int) $review->rating;
            if ($rating >= 1 && $rating <= 5) {
                $distribution[$rating]++;
            }
        }

        return $distribution;
    }
}
