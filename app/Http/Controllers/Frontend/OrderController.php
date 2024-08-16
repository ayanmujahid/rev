<?php

namespace App\Http\Controllers\Frontend;

use Exception;
use Stripe\Stripe;
use App\Models\Cart;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Models\ShippingAddress;
use App\Models\SystemSetting;
use App\Models\TrackingAffiliation;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Cache;
use App\Http\Controllers\Controller;
use Stripe\Checkout\Session as StripeSession;

class OrderController extends Controller
{

    public function store(Request $request)
    {
        $validated = $request->validate([
            'address' => 'required',
            'town_city' => 'required',
            'phone' => 'required',
            // 'cart' => 'required|json',
            'shipping_service' => 'required',
            'payment-options' => 'required',
            'affiliate_link' => 'nullable|url',
            'state_code' => 'required',
            'country_code' => 'required',
            'zip_code' => 'required',
        ]);

        DB::beginTransaction();

        $shippingAddress = ShippingAddress::create([
            'address' => $validated['address'],
            'town_city' => $validated['town_city'],
            'phone' => $validated['phone'],
            'state_code' => $validated['state_code'],
            'country_code' => $validated['country_code'],
            'zip_code' => $validated['zip_code'],
            'message' => $request['message'] ?? '',
        ]);

        $subtotal = 0;
        if (session('cart')) {
            foreach (session('cart') as $sku_code => $value) {
                $subtotal =  $subtotal + ($value['price'] * $value['quantity']);
            }
        }

        $shippingCost = SystemSetting::select($request['shipping_service'])->first()->pluck($request['shipping_service'])->toArray();
        $shippingCost = $shippingCost[0];
        $total = $subtotal + $shippingCost;

        $customOrderId = $this->generateCustomOrderId();

        // Use the affiliate link from the form or default to the previous URL
        $affiliateLink = $validated['affiliate_link'] ?? URL::previous();

        if (auth()) {
            $user_id = auth()->id();
        } else {
            $user_id = 0;
        }

        $order = Order::create([
            'order_id' => $customOrderId,
            'user_id' => $user_id,
            'shipping_address_id' => $shippingAddress->id,
            'subtotal' => $subtotal,
            'shipping_cost' => $shippingCost,
            'total' => $total,
            'affiliate_link' => $affiliateLink, // Store referral URL as affiliate_link
            'payment_status' => 'pending',
        ]);

        $cartItems = session('cart');

        // dd($cartItems);

        foreach ($cartItems as $item) {
            Cart::create([
                'order_id' => $order->id,
                'product_id' => $item['product_id'],
                'title' => $item['name'],
                'quantity' => $item['quantity'],
                'total_price' => $item['price'],
                'image_path' => $item['image'],
                'print_provider_id' => $item['print_provider_id'],
                'blueprint_id' => $item['blueprint_id'],
            ]);
        }


        DB::commit();

        // $checkTrackingAffiliation = TrackingAffiliation::where('user_id', $user_id);
        // $userCode = Cache::get('user_code');

        // if ($checkTrackingAffiliation->count() > 0) {

            // TrackingAffiliation::where('user_id', $user_id)->update([
            //     'amount' =>  $total,
            //     'status' =>  1,
            // ]);

            // $this->affiliatedCalculation($user_id, $userCode);
        // }

        // Cache::forget('user_code');

        Stripe::setApiKey(env('STRIPE_SECRET'));

        $session = StripeSession::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => 'Total Order',
                    ],
                    'unit_amount' => $total * 100,
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => route('order.success') . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('order.cancel'),
        ]);

        session()->put('order_id', $order->id);

        return redirect()->to($session->url)->with('order_id', $order->id);
    }

    protected function generateCustomOrderId()
    {
        $lastOrder = Order::orderBy('created_at', 'desc')->first();
        $nextId = $lastOrder ? ((int) substr($lastOrder->order_id, 5) + 1) : 1;
        return 'ORDID' . str_pad($nextId, 5, '0', STR_PAD_LEFT);
    }

    protected function calculateShippingCost($shippingService)
    {
        $cost = 0.00;

        switch ($shippingService) {
            case 'express':
                $cost = 10.00;
                break;
            case 'standard':
                $cost = 5.00;
                break;
            case 'store':
                $cost = 0.00;
                break;
            default:
                throw new Exception("Invalid shipping service selected.");
        }

        return $cost;
    }

    public function affiliatedCalculation($buyer_id, $code)
    {
        $a = 0;
        $b = 0;
        $c = 0;
        $add = 0;
        $total = 0;

        // $get_id = User::where('user_code', $code)->first()->id;
        $c_data = TrackingAffiliation::where('user_id', $buyer_id)->first();
        $all_data = TrackingAffiliation::where('affiliated_code', $code)->where('user_id', '!=', $buyer_id)->orderBy('id', 'DESC')->get();

        $c = (15 / 100) * $c_data->amount;

        // echo $c;

        foreach ($all_data as $key => $value) {

            // echo "<pre>";
            // print_r($value->user_id);
            // echo "</pre>";
            if ($key == 0) {
                if ($value->user_id != $buyer_id) {
                    $b = (30 / 100) * $c;
                    // dd($c);
                    TrackingAffiliation::where('user_id', $value->user_id)->update([
                        'distribut_amount' =>  $b
                    ]);
                }
            } else {

                if ($value->user_id != $buyer_id) {
                    $b = (30 / 100) * $b;

                    TrackingAffiliation::where('user_id', $value->user_id)->update([
                        'distribut_amount' =>  $b
                    ]);
                }
            }

            $add = $b;
            $total += $add;
        }

        $a = $c - $total;

        TrackingAffiliation::where('user_id', $buyer_id)->update([
            'distribut_amount' =>  $a
        ]);
    }
}
