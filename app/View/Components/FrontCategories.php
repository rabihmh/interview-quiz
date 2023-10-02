<?php

namespace App\View\Components;

use App\Models\Category;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\Component;

class FrontCategories extends Component
{
    public Collection $categories;

    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->categories = collect();
        $cachedCategories = Cache::tags('categories')->get('all_categories');

        if ($cachedCategories === null) {
            $this->categories = Category::all();
            Cache::tags('categories')->put('all_categories', $this->categories, now()->addDays(7));
        } else {
            $this->categories = $cachedCategories;
        }
    }


    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.front-categories');
    }
}
