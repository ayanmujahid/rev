<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\LatestVideo;
use App\Models\ProductCategory;
use App\Models\Product;
use App\Models\FAQ;
use App\Models\HappyUser;
use App\Models\Cart;
use App\Models\Package;
use Auth;
use Mail;
use DB;

class AffiliateShopController extends Controller
{
    /**
     * Fetches all active FAQs and HappyUsers, then returns the affiliate view with this data.
     *
     * @return View
     */
    public function index()
    {
        $lastValue = last(request()->segments());
        Cache::forever('user_code', $lastValue);
        if(!auth()->check()){
            return redirect()->route('login',['affiliate_key'=>$lastValue]);
        }
        $permanentValue = Cache::get('permanent_key');


        $categories = ProductCategory::where('status', 'active')->get();
        $products   = Product::where('status', 'active')->get();
        $latest_product = Product::where('status', 'active')->latest()->take(6)->get();

        $recommended_products = Cart::select(
            'product_id',
            DB::raw('COUNT(*) as count'),
            DB::raw('
                CASE
                    WHEN image_path LIKE "%printify%" THEN "Printify"
                    ELSE "Shop"
                END as type
            ')
        )
            ->groupBy('product_id', 'type')
            ->orderBy('count', 'desc')
            ->get()->toArray();

        return view('frontend.layout.affiliate-shop', compact('categories', 'products', 'latest_product', 'recommended_products'));
    }


    //     public function affiliate_code()
    //     {
    //         if (Auth::check()) {
    //             return view('affiliate_code');
    //         } else {
    //             return redirect()->route('login')->with('t-error', 'You need to log in first.');
    //         }
    //     }


    //     public function claim_code()
    //     {
    //         if (Auth::check()) {
    //             return view('claim_code');
    //         } else {
    //             return redirect()->route('login')->with('t-error', 'You need to log in first.');
    //         }
    //     }




    //     public function verification_submit(Request $request)
    // {
    //     // Generate OTP
    //     $otp = rand(100000, 999999);

    //     // Create Package record
    //     $package = Package::create([
    //         "user_id" => Auth::id(),
    //         'full_name' => $request->input('full_name'),
    //         'email' => $request->input('email'),
    //         'verification' => $otp, // Store the OTP directly
    //         'verification_status' => 0
    //     ]);

    //     // Encrypt package ID for URL
    //     $user_id = encrypt($package->id);

    //     // Send verification email
    //     Mail::send('email.verify', ['otp' => $otp, 'user_id' => $user_id], function ($message) use ($request) {
    //         $message->from(env('MAIL_FROM_ADDRESS'));
    //         $message->to($request->email); // Send email to the provided email address
    //         $message->subject('OTP Verification');
    //     });

    //     // Redirect to verification page with encrypted user_id
    //     return redirect()->route('user_verification', $user_id)->with('t-success', 'Enter your OTP code');
    // }


    //     public function otp_submit(Request $request)
    //     {
    //         $userId = $request->user_id;
    //         $user = Package::find($userId);
    //         if ($user && $user->code == $request->code) {
    //             $user->verification_status = 1;
    //             $user->save();
    //             Auth::loginUsingId($userId);
    //             return redirect()->route('thankyou')->with('notify_success', 'You claim the Free Affiliation'); // Redirect to home after successful verification
    //         }
    //         $email = $user->email;
    //         $user_id = encrypt($request->user_id);
    //          Mail::send('email.thankyou', ['user_id' => $user_id], function ($message) use ($email) {
    //         $message->from(env('MAIL_FROM_ADDRESS'));
    //         $message->to($email);
    //         $message->subject('Thank you');
    //     });
    //         return redirect()->route('user_verification', $user_id)->with('notify_error', 'Invalid Claiming code');
    //     }



    //     public function user_verification($user_id)
    //     {
    //         $user_id = decrypt($user_id);
    //         return view('verification', compact('user_id'));
    //     }


    //     public function code_verification(Request $request)
    //     {
    //         // Check if the user is logged in
    //         if (!Auth::check()) {
    //             return redirect()->route('login')->with('t-error', 'You need to log in first.');
    //         }

    //         // Find the user by their email
    //         $current_user = Package::where("email", $request->email)->first();

    //         if ($current_user) {
    //             if ($current_user->verification_status == 1) {
    //                 // User is already verified, proceed to home or success page
    //                 return redirect()->route('homepage')->with('t-success', 'You have already verified your code!');
    //             } else {
    //                 // User is not verified, redirect to verification page with user_id
    //                 $user_id = encrypt($current_user->id);
    //                 return redirect()->route('user_verification', $user_id)->with('t-error', 'Please verify your account with the code sent to your email.');
    //             }
    //         } else {
    //             // User not found, redirect to create a new redeem code
    //             return redirect()->route('affiliate')->with('t-error', 'No code found for this email. Please create a new redeem code.');
    //         }
    //     }
}
