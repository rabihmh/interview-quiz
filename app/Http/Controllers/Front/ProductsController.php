<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Queries\ProductQuery;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $categories = Category::active()->get();
        $products = Product::query()->withAvailableQuantity()->with('category:id,name')->paginate();
        return view('front.products.index', compact('products', 'categories'));
    }


    /**
     * Display the specified resource.
     */
    public function show(Product $product): View
    {
        return view('front.products.show', compact('product'));
    }

    public function search(Request $request): JsonResponse
    {
        $filters = $request->all();
        $products = ProductQuery::getFilteredProducts($filters);
        return response()->json($products, 200);

    }


}
