<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\{Auth};
use App\Models\{PreOrderSpecial, Product, Cart, Gift};

class CheckoutController extends Controller
{

    public function index()
    {
        if (Auth::check()) {
            $gifts = Gift::where('status', 'active')->get();
            $latest_product = Product::where('status', 'active')->latest()->take(6)->get();
            $carts = Cart::get();
            $preOrderSpecial = PreOrderSpecial::where('status', 'active')->first();
            $data = [
                // 'preOrderProduct' => $preOrderProduct,
                'preOrderSpecial' => $preOrderSpecial,
                // 'pageSamples'     => $pageSamples,
                // 'latestVideos'    => $latestVideos,
                // 'happyusers'      => $happyusers,
                // 'products'        => $products,
                // 'salesGoals'       => $salesGoals,
            ];
            $is_spark = false;
            $is_ROGUE_ASSASSIN = false;
            if (session('cart')) {

                $cart = session()->get('cart');
                if ($cart) {
                    foreach ($cart as $val) {
                        if (strpos(strtolower($val['name']), 'spark') !== false) {
                            $is_spark = true;
                        }
                    }
                } else {
                    return redirect()->url('/')->with('t-error', 'Cart is Empty');
                }
            } else {
                return redirect()->route('homepage')->with('t-error', 'Cart is Empty');
            }

            return view('frontend.layout.checkout', compact('carts', 'data', 'latest_product', 'is_spark','is_ROGUE_ASSASSIN','gifts'));
            // return view('frontend.layout.checkout');

        } else {
            return redirect()->back()->with('t-error', 'Login/Register for checkout');
        }
    }
}
