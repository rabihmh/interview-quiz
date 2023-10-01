<?php

namespace App\Queries;

use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;

class ProductQuery
{
    public static function getFilteredProducts($filters): Collection|array
    {
        $query = Product::query()->with('category:id,name');

        if (isset($filters['categories']) && is_array($filters['categories'])) {
            $query->whereIn('category_id', $filters['categories']);
        }

        if (isset($filters['prices']) && is_array($filters['prices'])) {
            foreach ($filters['prices'] as $priceRange) {
                $priceRange = explode('-', $priceRange);
                if (count($priceRange) === 2) {
                    $minPrice = (float)$priceRange[0];
                    $maxPrice = (float)$priceRange[1];
                    $query->orWhereBetween('price', [$minPrice, $maxPrice]);
                }
            }
        }

        if (isset($filters['searchTerm'])) {
            $searchTerm = $filters['searchTerm'];
            $query->where(function ($subQuery) use ($searchTerm) {
                $subQuery->where('name', 'like', '%' . $searchTerm . '%')
                    ->orWhere('description', 'like', '%' . $searchTerm . '%');
            });
        }

        return $query->get();
    }
}
