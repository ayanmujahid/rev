<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use App\Models\Gift;
use Exception;
use App\Helper\Helper;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class CartController extends Controller {
    /**
     * Validates the request data, then stores each item in the cart for the authenticated user.
     * If successful, redirects to the checkout index with a success message.
     * If validation fails or storing the cart fails, redirects back with the appropriate error message.
     *
     * @param Request $request The incoming HTTP request.
     * @return RedirectResponse
     */
    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            'cart'              => 'required|array',
            'cart.*.quantity'   => 'required|integer|min:1',
            'cart.*.totalPrice' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $userId = Auth::id();

        try {
            foreach ($request->cart as $productId => $item) {
                $cart              = new Cart;
                $cart->user_id     = $userId;
                $cart->product_id  = $productId;
                $cart->quantity    = $item['quantity'];
                $cart->total_price = $item['totalPrice'];
                $cart->save();
            }

            return redirect()->route('checkout.index')->with('t-success', 'Cart stored successfully');
        } catch (Exception) {
            return redirect()->back()->with('t-error', 'Failed to store cart');
        }
    }

    public function get_cart(){
        //session()->forget('cart');
        if (session('cart')) {
            $cart = session()->get('cart');
            $status['message'] = 'Cart Exist';
            $status['status'] = 1;
        }else{
            $cart = array();
            $status['message'] = 'Cart is Empty';
            $status['status'] = 0;
        }
        
        $status['body'] = $cart;
        return json_encode($status);
    }

    public function save_cart(Request $request)
    {
        $product_id = $request['product_id'];
        $product = Product::where('id', $product_id)->first();
        if($request['type'] == "Shop"){
            $price = $product->discount_price;
            $title = $product->title;
            $product_id = $product->id;
            $image = Helper::getImage($product->image);
            $print_provider_id = "";
            $blueprint_id = "";
        }else{ // Printify
            $price = $request['price'];
            $title = $request['title'] . ' - Printify';
            $product_id = $request['product_id'];
            $image = $request['image'];
            $print_provider_id = $request['print_provider_id'];
            $blueprint_id = $request['blueprint_id'];
        }
       
        $quantity = $request['quantity'];
        
        // if($request['quantity'] > $product->stock){
        //     $msg = '"' . $product->stock . '" quantity of "' . $product->name . '" in stock';
        //     $status['message'] = $msg;
        //     $status['status'] = 0;
        //     return json_encode($status);
        // }
        if (session('cart')) {
            $cart = session()->get('cart');
            $cart[$product_id] = [
                "product_id" => $product_id,
                "name" => $title,
                "price" => $price,
                "quantity" => isset($cart[$product_id]) ? $cart[$product_id]['quantity'] + $quantity : $quantity,
                "image" => $image,
                'print_provider_id' =>  $print_provider_id,
                'blueprint_id' => $blueprint_id,
            ];
            session()->put('cart', $cart);
        } else {
            $cart = array();
            $cart[$product_id]['product_id'] = $product_id;
            $cart[$product_id]['name'] = $title;
            $cart[$product_id]['price'] = $price;
            $cart[$product_id]['quantity'] = $quantity;
            $cart[$product_id]['image'] = $image;
            $cart[$product_id]['print_provider_id'] = $print_provider_id;
            $cart[$product_id]['blueprint_id'] = $blueprint_id;
            session()->put('cart', $cart);
        }


        // if (Session::has('cart'))
        // {
        //     $cart = Session::get('cart');
        // }
        // $cart[$code]['product_id'] = $product_id;
        // $cart[$code]['price'] = $price;
        // $cart[$code]['quantity'] = $quantity;
        // Session::put('cart', $cart);

        $msg = '"' . $title . '" has been added to cart';
        $status['message'] = $msg;
        $status['status'] = 1;
        $status['cart_items_count'] = count(session()->get('cart'));
        return json_encode($status);
    }

    public function update_cart(Request $request)
    {
        $product_id = $request['product_id'];
        $product = Product::where('id', $product_id)->first();
        $price = $product->price;
        $quantity = $request['quantity'];
        $code = $product->sku;

        if (session('cart')) {
            $cart = session()->get('cart');
            $cart[$product_id] = [
                ...$cart[$product_id],
                'quantity' => $quantity
            ];
            session()->put('cart', $cart);

            $msg = '"' . $product->name . '" quantity has been updated to cart';
            $status['message'] = $msg;
            $status['status'] = 1;
            return json_encode($status);
        }
        $msg = 'Request failed!';
        $status['message'] = $msg;
        $status['status'] = 0;
        return json_encode($status);


        // if (Session::has('cart'))
        // {
        //     $cart = Session::get('cart');
        // }
        // $cart[$code]['product_id'] = $product_id;
        // $cart[$code]['price'] = $price;
        // $cart[$code]['quantity'] = $quantity;
        // Session::put('cart', $cart);

    }
    
     public function getGifts(Request $request)
    {
        $is_spark = false;
        $cart = $request->session()->get('cart');

        if ($cart) {
            foreach ($cart as $val) {
                if (strpos(strtolower($val['name']), 'spark') !== false) {
                    $is_spark = true;
                    break;
                }
            }
        }

        if ($is_spark) {
            $gifts = Gift::where('status', 'active')->get();
            return response()->json(['gifts' => $gifts]);
        } else {
            return response()->json(['gifts' => []]);
        }
    }
    
    

    public function remove_cart()
    {
        $sku_code = $_POST['id'];
        if (session()->has('cart')) {
            $cart = session()->get('cart');
            session()->forget('cart');
            unset($cart[$sku_code]);
            session()->put('cart', $cart);
            
            $status['message'] = "Product has been removed from Cart";

            $sub_total = 0;
            if (session('cart')){
                foreach (session('cart') as $sku_code => $value){
                    $sub_total += $value['price'];
                }
            }


            $status['cart_total_amount'] = $sub_total;
            $status['status'] = 1;
            $status['cart_items_count'] = count(session()->get('cart'));
            return json_encode($status);
        } else {
            $status['message'] = "Cart is Empty";
            $status['status'] = 0;
            return json_encode($status);
        }
    }

}
