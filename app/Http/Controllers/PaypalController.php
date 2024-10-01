<?php

namespace App\Http\Controllers;

use Srmklive\PayPal\Services\PayPal as PayPalClient;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Product;

class PaypalController extends Controller
{
    public function payment()
    {
        $cart = Cart::where('user_id', auth()->user()->id)
            ->where('order_id', null)
            ->get()
            ->toArray();

        $data = [];
        $data['intent'] = 'CAPTURE';

        $data['purchase_units'] = array_map(function ($item) {
            $name = Product::where('id', $item['product_id'])->pluck('title')->first();
            return [
                'amount' => [
                    'currency_code' => 'USD', // You can change this to your preferred currency
                    'value' => $item['price'] * $item['quantity'],
                ],
                'description' => $name
            ];
        }, $cart);

        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $paypalToken = $provider->getAccessToken();

        $provider->setAccessToken($paypalToken);
        $response = $provider->createOrder($data);

        if (isset($response['id']) && $response['status'] === 'CREATED') {
            foreach ($response['links'] as $link) {
                if ($link['rel'] === 'approve') {
                    return redirect($link['href']);
                }
            }
        }

        return redirect()->back()->with('error', 'Something went wrong with PayPal.');
    }


    public function cancel()
    {
        dd('Your payment is canceled. You can create cancel page here.');
    }

    public function success(Request $request)
    {
        // Use PayPalClient instead of ExpressCheckout
        $provider = new PayPalClient;
        $response = $provider->getExpressCheckoutDetails($request->token);

        if (in_array(strtoupper($response['ACK']), ['SUCCESS', 'SUCCESSWITHWARNING'])) {
            request()->session()->flash('success', 'You successfully paid through PayPal! Thank you.');
            session()->forget('cart');
            session()->forget('coupon');
            return redirect()->route('home');
        }

        request()->session()->flash('error', 'Something went wrong. Please try again!');
        return redirect()->back();
    }
}
