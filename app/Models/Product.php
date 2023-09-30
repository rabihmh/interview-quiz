<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $appends = ['image_url'];

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
}
