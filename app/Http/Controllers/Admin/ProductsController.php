<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\Category;
use App\Models\Product;
use App\Traits\DeleteImageTrait;
use App\Traits\UploadImageTrait;
use Illuminate\View\View;

class ProductsController extends Controller
{
    use UploadImageTrait, DeleteImageTrait;

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $products = Product::with('category:id,name')->paginate(15);
        return view('admin.products.index', compact('products'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $categories = Category::select('id', 'name', 'slug')->active()->get();
        $product = new Product();
        return view('admin.products.create', compact('product', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request)
    {
        $data = $request->except('image');
        if ($request->hasFile('image')) {
            $data['image'] = $this->uploadImage($request->file('image'), 'products');
        }
        Product::create($data);
        return redirect()->route('admin.products.index')->with('success', 'products created successfully');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product): View
    {
        $categories = Category::select('id', 'name', 'slug')->active()->get();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductRequest $request, string $id)
    {
        $product = Product::findOrFail($id);
        $old_image = $product->image;
        $data = $request->except('image');
        if ($request->hasFile('image')) {
            $this->deleteImage($old_image);
            $data['image'] = $this->uploadImage($request->file('image'), 'categories');
        }
        $product->update($data);
        return redirect()->route('admin.products.index')->with('success', 'updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::findOrFail($id);
        if ($product->image) {
            $this->deleteImage($product->image);
        }
        $product->delete();
        return redirect()->route('admin.products.index')->with('deleted', 'product deleted');
    }
}
