<?php

namespace App\Observers;

use App\Models\Category;
use Illuminate\Support\Facades\Cache;

class CategoryObserver
{
    /**
     * Handle the Category "created" event.
     */
    public function created(Category $category): void
    {

    }

    /**
     * Handle the Category "updated" event.
     */
    public function updated(Category $category): void
    {
        Cache::tags('categories')->forget('category_' . $category->id);
        $updatedCategory = Category::find($category->id);
        Cache::tags('categories')->put('category_' . $updatedCategory->id, $updatedCategory, now()->addDays(7));

    }

    /**
     * Handle the Category "deleted" event.
     */
    public function deleted(Category $category): void
    {
        Cache::tags('categories')->forget('category_' . $category->id);
    }

    /**
     * Handle the Category "restored" event.
     */
    public function restored(Category $category): void
    {
        //
    }

    /**
     * Handle the Category "force deleted" event.
     */
    public function forceDeleted(Category $category): void
    {
        //
    }
}
