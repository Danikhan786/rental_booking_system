<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function payment(Request $request)
    {
        $stripe = new \Stripe\StripeClient(config('stripe.stripe_sk'));

        $stripe->checkout->sessions->create([
          'line_items' => [
            [
              'price_data' => [
                'currency' => 'usd',
                'product_data' => [
                    'name' => $request->property->name 
                ],
                'unit_amount' => $request->property->price,
              ],
              'quantity' => 1,
            ],
          ],
          'mode' => 'payment',
          'success_url' => 'https://example.com/success',
          'cancel_url' => 'https://example.com/cancel',
        ]);
        
        
    }

    public function success()
    {
        return "Payment is successful!";
    }

    public function cancel()
    {
        return "Payment is cancelled!";
    }
}
