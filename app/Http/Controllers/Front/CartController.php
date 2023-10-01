<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use App\Repositories\Cart\CartRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CartController extends Controller
{
    protected CartRepository $cart;

    public function __construct(CartRepository $cart)
    {
        $this->cart = $cart;
    }

    /**
     * Display a listing of the resource.
     *
     */
    public function index(): View
    {

        return view('front.cart', [
            'cart' => $this->cart
        ]);
    }


    public function store(Request $request): RedirectResponse|JsonResponse
    {
        $request->validate([
            'product_id' => ['required', 'int', 'exists:products,id'],
            'quantity' => ['nullable', 'int', 'min:1']
        ]);

        $product = Product::findOrFail($request->post('product_id'));
        $quantityToAdd = $request->post('quantity', 1);

        if ($product->quantity < $quantityToAdd) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Not enough quantity available for this product.'
                ], 422);
            }

            return redirect()->route('front.cart.index')->with(['error' => 'Not enough quantity available for this product.']);
        }

        $product->quantity -= $quantityToAdd;
        $product->save();

        $this->cart->add($product, $quantityToAdd);

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Item added to cart'
            ], 201);
        }

        return redirect()->route('front.cart.index')->with(['success' => 'Product added to cart']);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'quantity' => ['required', 'int', 'min:1']
        ]);

        $cart = Cart::findOrFail($id);

        $product = Product::where('id', $cart->product_id)->first();

        $currentQuantity = $cart->quantity;
        $newQuantity = (int)$request->post('quantity');
        $quantityDifference = $newQuantity - $currentQuantity;

        if ($product->quantity < $quantityDifference) {
            return response()->json([
                'message' => 'Requested quantity exceeds the available quantity for this product.',
            ], 422);
        }

        $this->cart->update($id, $newQuantity);

        $product->quantity -= $quantityDifference;
        $product->save();

        return response()->json([
            'message' => 'Cart item updated',
        ]);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        $this->cart->delete($id);
        return response()->json([
            'message' => 'Item deleted',
        ]);
    }
}
