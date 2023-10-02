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
            return (int)$item->price * $item->quantity;
        });
        $stripe = new StripeClient(config('services.stripe.secret_key'));
        $paymentIntent = $stripe->paymentIntents->create([
            'amount' => $amount,
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
                $order->payment_method = 'stripe';
                $order->payment_status = 'paid';
                $order->status = 'completed';
                $order->save();
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
