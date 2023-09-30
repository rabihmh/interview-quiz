<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\View\View;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $products = Product::query()->with('category:id,name')->paginate();
        return view('front.products.index', compact('products'));
    }


    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return view('front.products.show', compact('product'));
    }

}
