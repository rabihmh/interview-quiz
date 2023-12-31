<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class AdminSidebar extends Component
{
    public array $items;

    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->items = require(base_path('data/AdminSidebarItems.php'));
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.admin-sidebar');
    }
}
