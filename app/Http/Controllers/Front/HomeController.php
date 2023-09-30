<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function home(): View
    {
        $categories = Category::where('parent_id', null)->get();
        $products = Product::with('category')->active()->latest()->take(8)->get();
        return view('front.home', compact('products', 'categories'));
    }
}
