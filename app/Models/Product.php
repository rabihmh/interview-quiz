<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $appends = ['image_url', 'sale_percentage_discount'];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    protected static function booted()
    {
        static::creating(function (Product $product) {
            $product->slug = Str::slug($product->name);
        });
        static::updating(function (Product $product) {
            $product->slug = Str::slug($product->name);
        });
    }

    public function scopeActive(Builder $builder)
    {
        $builder->where('status', '=', 'active');
    }

    public function scopeWithAvailableQuantity(Builder $builder)
    {
        $builder->where('quantity', '>=', 1);
    }

    public function getImageUrlAttribute()
    {
        if (!$this->image) {
            return asset('defaultProduct.jpg');
        }
        if (Str::startsWith($this->image, ['http://', 'https://'])) {
            return $this->image;
        }
        return asset('storage/' . $this->image);
    }

    public function getSalePercentageDiscountAttribute(): int|string
    {
        if (!$this->compare_price) {
            return 0;
        }

        return round(100 * $this->price / $this->compare_price, 1) . '%';
    }

}
