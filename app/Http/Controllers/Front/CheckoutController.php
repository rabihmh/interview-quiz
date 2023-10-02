<?php

namespace App\Http\Controllers\Front;

use App\Events\OrderCreate;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Repositories\Cart\CartRepository;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Symfony\Component\Intl\Countries;
use Throwable;

class CheckoutController extends Controller
{
    /**
     * @throws Exception
     */
    public function create(CartRepository $cart): View|RedirectResponse
    {
        $countries = Countries::getNames();
        if ($cart->get()->isEmpty()) {
            return redirect()->back()->with('error', 'Cart is Empty');
            //throw new exception ('Cart is Empty');
        }
        return view('front.checkout', ['cart' => $cart, 'countries' => $countries]);
    }

    public function store(Request $request, CartRepository $cart): RedirectResponse
    {
        $request->validate([
            'addr.billing.*' => ['required', 'string', 'max:255'],
            'addr.shipping.*' => ['required', 'string', 'max:255'],
        ]);

        $items = $cart->get();
        DB::beginTransaction();
        try {

            $order = Order::create([
                'user_id' => Auth::id(),
                'total' => $cart->total(),
                'payment_method' => 'cod',
            ]);
            foreach ($items as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'product_name' => $item->products->name,
                    'price' => $item->products->price,
                    'quantity' => $item->quantity,
                ]);
            }
            foreach ($request->post('addr') as $type => $address) {
                $address['type'] = $type;
                $order->addresses()->create($address);
            }
            DB::commit();
            event(new OrderCreate($order));
        } catch (Throwable $e) {
            DB::rollBack();
            throw $e;
        }
        return redirect()->route('front.order.payments.create', $order->id);
    }

}
