<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'is_active',
        'parent_id',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($category) {
            if (empty($category->slug)) {
                $category->slug = Str::slug($category->name);
            }
        });

        static::updating(function ($category) {
            if ($category->isDirty('name')) {
                $category->slug = Str::slug($category->name);
            }
        });
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class);
    }

    // Relație către categoria părinte
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    // Relație către subcategorii
    public function children(): HasMany
    {
        return $this->hasMany(Category::class, 'parent_id')->where('is_active', true);
    }

    // Toate subcategoriile (inclusiv inactive)
    public function allChildren(): HasMany
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    // Verifică dacă este categorie principală
    public function isParent(): bool
    {
        return is_null($this->parent_id);
    }

    // Verifică dacă este subcategorie
    public function isChild(): bool
    {
        return !is_null($this->parent_id);
    }

    // Obține toate categoriile principale (fără părinte)
    public static function getParentCategories()
    {
        return self::whereNull('parent_id')->where('is_active', true)->orderBy('name')->get();
    }

    // Scope pentru categorii principale
    public function scopeParents($query)
    {
        return $query->whereNull('parent_id');
    }

    // Scope pentru subcategorii
    public function scopeChildren($query)
    {
        return $query->whereNotNull('parent_id');
    }
}