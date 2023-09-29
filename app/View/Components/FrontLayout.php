<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class FrontLayout extends Component
{
    public string $title;

    /**
     * Create a new component instance.
     */
    public function __construct($title = null)
    {
        $this->title = $title ?? config('APP_NAME');
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('layouts.front-layout');
    }
}
