<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Stripe\Exception\ApiErrorException;
use Stripe\StripeClient;

class PaymentsController extends Controller
{
    public function create(Order $order)
    {
        return view('front.payments.create', ['order' => $order]);
    }

    /**
     * @throws ApiErrorException
     */
    public function createStripePaymentIntent(Order $order): array
    {
        $amount = $order->items->sum(function ($item) {
            return $item->price * $item->quantity;
        });
        $stripe = new StripeClient(config('services.stripe.secret_key'));
        $paymentIntent = $stripe->paymentIntents->create([
            'amount' => (int)($amount * 100),//amount in cent
            'currency' => 'usd',
            'payment_method_types' => ['card'],
        ]);
        return [
            'clientSecret' => $paymentIntent->client_secret,
        ];
    }

    public function confirm(Request $request, Order $order)
    {
        $stripe = new StripeClient(config('services.stripe.secret_key'));
        $paymentIntent = $stripe->paymentIntents->retrieve(
            $request->query('payment_intent'),
            []
        );
        try {
            if ($paymentIntent->status == 'succeeded') {

                $payment = new Payment();
                $payment->forceFill([
                    'order_id' => $order->id,
                    'amount' => $paymentIntent->amount,
                    'currency' => $paymentIntent->currency,
                    'status' => 'completed',
                    'method' => 'stripe',
                    'transaction_id' => $paymentIntent->id,
                    'transaction_data' => json_encode($paymentIntent)
                ])->save();
            }
        } catch (QueryException $e) {
            echo $e->getMessage();
            return;
        }
        return redirect()->route('home')->with('status', 'payment succeeded');
    }
}
