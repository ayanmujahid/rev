<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\AffiliateDistribution;
use App\Models\AffiliateLink;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Order;
use App\Models\ProductPromotion;
use App\Models\MainstreamEntertainment;
use App\Models\ClaimRequest;
use App\Models\User;
use App\Models\TrackingAffiliation;
use App\Models\Cart;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    /**
     * Fetches all active MainstreamEntertainments and the first active, free ProductPromotion.
     * Returns the home view with this data.
     *
     * @return View
     */
    public function index()
    {
        $MainstreamEntertainments = MainstreamEntertainment::where('status', 'active')->get();
        $ProductPromotions        = ProductPromotion::where('status', 'active')->where('promotion_type', 'Free')->first();
        return view('frontend.layout.home', compact('MainstreamEntertainments', 'ProductPromotions'));
    }

    public function show()
    {
        return view('frontend.layout.whoweare');
    }

    public function claim_request_submit(Request $request)
    {
        $package = ClaimRequest::create([
            'request' => $request->input('request'),
        ]);
        return back()->with('t-success', 'You Successfully Made Your Claim Request');
    }

    public function paymentSuccessOLD()
    {

        //$session_id = 'cs_test_a16gXi4uwBFTfE51FgMmP830hYxXToj3PVnAlsojNlChb4iMUc4yF28MLq';
        $session_id = $_GET['session_id'];
        $api_key = env('STRIPE_SECRET');

        $url = 'https://api.stripe.com/v1/checkout/sessions/' . $session_id;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Authorization: Basic ' . base64_encode($api_key . ':')
        ));

        $response = curl_exec($ch);

        if ($response === false) {
            echo 'Error: ' . curl_error($ch);
        } else {
            $decoded_response = json_decode($response, true);
            echo 'Session Details:';
            echo '<pre>';
            //print_r($decoded_response);
            echo '</pre>';
        }

        curl_close($ch);
        $orderId = session('order_id');
        if ($decoded_response['payment_status'] == "paid") {
        }
        if (!session()->has('order_id')) {
            return redirect()->route('homepage')->with('t-error', 'No Order Exist');
        }
        $orderId = session('order_id');

        $order = Order::find($orderId);
        if ($order) {
            $order->payment_intent = $decoded_response['payment_intent'];
            $order->record_id = $decoded_response['id'];
            $order->resp_data = serialize($decoded_response);

            $order->update(['payment_status' => 'successful']);
        }
        // session()->forget('cart');
        // session()->forget('order_id');
        return view('frontend.payment.success');
    }
    public function getParentUsers(User $user, &$users = []){
        $users[] = $user;
        if($user->user_code!='no-code'){
            if(AffiliateLink::where('user_code', $user->user_code)->count()>0){
                $affiliateCodeUser = AffiliateLink::where('user_code', $user->user_code)->first()->user;
                return $this->getParentUsers($affiliateCodeUser, $users);
            }
            return $users;
        }else{
            return $users;
        }
    }
    public function paymentSuccess()
    {
        $session_id = $_GET['session_id']; // Assuming you're passing session_id as a query parameter
        $api_key = env('STRIPE_SECRET');

        $url = 'https://api.stripe.com/v1/checkout/sessions/' . $session_id;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Authorization: Basic ' . base64_encode($api_key . ':')
        ));

        $response = curl_exec($ch);

        if ($response === false) {
            echo 'Error: ' . curl_error($ch);
        } else {
            $decoded_response = json_decode($response, true);
        }

        curl_close($ch);

        // Check if payment was successful
        if ($decoded_response['payment_status'] == "paid") {
            $orderId = session('order_id');
            if (!$orderId) {
                return redirect()->route('homepage')->with('t-error', 'No Order Exist');
            }
            
            // Retrieve order details from your database
            $order = Order::find($orderId);
            
            if ($order) {
                $amountForDistribution = ((floatval($order->total)/100)*15);
                $amountForDistributionOthers = ((floatval($amountForDistribution)/100)*30);
                $amountForDistribution = ($amountForDistribution-$amountForDistributionOthers);
                $code = Cache::get('user_code');
                if($code){
					if(AffiliateLink::where('user_code', $code)->count()>0){
						//distribute amount here
						$affiliateCodeUser = AffiliateLink::where('user_code', $code)->first()->user;
						$Distributiousers = $this->getParentUsers($affiliateCodeUser);
						foreach($Distributiousers as $Distributiouserk=>$Distributiouser){
							if($Distributiouserk==0){
								AffiliateDistribution::create([
									'user_id' => $Distributiouser->id,
									'shop_code' => $code,
									'order_id' => $orderId,
									'amount' => $amountForDistribution,
								]);
							}else{
								$thirtyPercentAmountUpdateForNext = ((floatval($amountForDistributionOthers)/100)*30);
								AffiliateDistribution::create([
									'user_id' => $Distributiouser->id,
									'shop_code' => $code,
									'order_id' => $orderId,
									'amount' => ($amountForDistributionOthers-$thirtyPercentAmountUpdateForNext),
								]);
								$amountForDistributionOthers = $thirtyPercentAmountUpdateForNext;
							}
						}
						// AffiliateDistribution
						//distribute amount here end						
					}
                }
                Cache::forget('user_code');

                $order->payment_intent = $decoded_response['payment_intent'];
                $order->record_id = $decoded_response['id'];
                $order->resp_data = serialize($decoded_response);
                 $order->update(['payment_status' => 'successful']);
                $order->save();

                session()->forget('cart');
                session()->forget('order_id');

                return view('frontend.payment.success');

                // Retrieve products from cart where image_path contains "printify"
                $products = Cart::where('order_id', $order->id)
                    ->where('image_path', 'like', '%printify%')
                    ->get();

                if ($products->isEmpty()) {
                    return redirect()->route('homepage')->with('t-error', 'No Printify products found in cart');
                }

                // Prepare line_items array for Printify order
                $line_items = [];
                foreach ($products as $product) {
                    // Extract variant_id from product_id
                    $ids = explode('-', $product->product_id);
                    if (count($ids) > 1) {
                        $line_items[] = [
                            'variant_id' => $ids[1], // Assuming variant_id is the second part after '-'
                            'quantity' => $product->quantity,
                            'print_provider_id' => $product->print_provider_id,
                            'blueprint_id' => $product->blueprint_id,
                            'print_areas' => [
                                [
                                    'height' => 10,
                                    'width' => 10,
                                    'top' => 0,
                                    'left' => 0,
                                ]
                            ],
                        ];
                    }
                }

                // Prepare data to send to Printify API
                $printifyData = [
                    'recipient' => [
                        'name' => 'Walking Customer', // Adjust as per your requirement
                        'address1' => $order->shippingAddress->address,
                        'city' => $order->shippingAddress->town_city,
                        'state_code' => $order->shippingAddress->state_code,
                        'country_code' => $order->shippingAddress->country_code,
                        'zip' => $order->shippingAddress->zip_code,
                    ],
                    'line_items' => $line_items,
                ];

                /*
                // Send order creation request to Printify
                $curl = curl_init();
                curl_setopt_array($curl, array(
                    CURLOPT_URL => 'https://api.printify.com/v1/shops/'.env("PRINTIFY_STORE_ID").'/orders.json',
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'POST',
                    CURLOPT_POSTFIELDS => json_encode($printifyData),
                    CURLOPT_HTTPHEADER => array(
                        'Authorization: Bearer '.env('PRINTIFY_STORE_TOKEN'),
                        'Content-Type: application/json'
                    ),
                ));

                $printifyResponse = curl_exec($curl);


                if ($printifyResponse === false) {
                    echo 'Error: ' . curl_error($curl);
                } else {
                    // Process Printify API response
                    $printifyDecodedResponse = json_decode($printifyResponse, true);

                    // Handle Printify order creation response as needed
                    if (isset($printifyDecodedResponse['id'])) {


                        // Update your order status to reflect successful order creation on Printify
                        $order->printify_order_id = $printifyDecodedResponse['id'];

                        $order->payment_intent = $decoded_response['payment_intent'];
                        $order->record_id = $decoded_response['id'];
                        $order->resp_data = serialize($decoded_response);
                        $order->save();

                        // Clear session/cart information
                        // session()->forget('cart');
                        // session()->forget('order_id');

                        return view('frontend.payment.success');
                    } else {
                        // Handle error from Printify API
                        return redirect()->route('homepage')->with('t-error', 'Error creating order on Printify');
                    }
                }

                curl_close($curl);
                */
            } else {
                return redirect()->route('homepage')->with('t-error', 'Please contact system administrator to confirm your order is valid or not');
            }
        } else {
            return redirect()->route('homepage')->with('t-error', 'Your Payment not verified');
        }

        // Handle other scenarios or errors if necessary
        return redirect()->route('homepage')->with('t-error', 'Payment not successful');
    }

    public function paymenCancel()
    {
        $orderId = session('order_id');
        $order = Order::find($orderId);
        if ($order) {
            $order->update(['payment_status' => 'cancelled']);
        }
        return view('frontend.payment.cancel');
    }

    public function affiliatedCalculation()
    {
        $buyer_id = 28;
        $code = '4IhZO';
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
