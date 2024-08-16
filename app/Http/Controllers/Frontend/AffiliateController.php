<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\AffiliateLink;
use Illuminate\Http\Request;
use App\Models\LatestVideo;
use App\Models\Schedule;
use App\Models\Time;
use App\Models\FAQ;
use App\Models\HappyUser;
use App\Models\User;
use Auth;
use Mail;
use Illuminate\Support\Str;
use Illuminate\View\View;
use App\Models\Package;

class AffiliateController extends Controller
{
    /**
     * Fetches all active FAQs and HappyUsers, then returns the affiliate view with this data.
     *
     * @return View
     */
    public function index()
    {
        $user = Auth::user();
        $userPackages = [];

        if ($user) {
            // Retrieve user's packages with verification status
            $userPackages = Package::where('user_id', $user->id)->get();
        }

        $videos = LatestVideo::all();
         $schedules = Schedule::all();
         $schedules_time = Time::all();
        $faqs = FAQ::where('status', 'active')->get();
        $happyusers = HappyUser::where('status', 'active')->get();

        return view('frontend.layout.affiliate', compact('faqs', 'happyusers', 'userPackages', 'videos', 'schedules','schedules_time'));
    }


    public function affiliate_code()
    {
        if (Auth::check()) {
            return view('affiliate_code');
        } else {
            return redirect()->route('login')->with('t-error', 'You need to log in first.');
        }
    }



    public function claim_code()
    {
        if (Auth::check()) {
            return view('claim_code');
        } else {
            return redirect()->route('login')->with('t-error', 'You need to log in first.');
        }
    }




    public function verification_submit(Request $request)
    {
        // Generate OTP
        $otp = rand(100000, 999999);

        // Generate unique slug
        // $slug = Str::random(100); // Generates a random 10-character string
        // $slug = Auth::user()->user_code;
        $slug = Str::random(5);

        // Create the affiliate link
        $link = route('affiliate-shop', ['slug' => $slug]);

        // Create Package record
        $package = Package::create([
            'user_id' => Auth::id(),
            'full_name' => $request->input('full_name'),
            'affiliate_link' => $link, // Storing the generated link
            'email' => $request->input('email'),
            'verification' => $otp, // Store the OTP directly
            'verification_status' => 0
        ]);
        AffiliateLink::create([
            'user_id' => Auth::id(),
            'user_code' => $slug,
        ]);

        // Encrypt package ID for URL
        $user_id = encrypt($package->id);
        // $user_id = encrypt(Auth::user()->id);

        // Send verification email
        Mail::send('email.verify', ['otp' => $otp, 'user_id' => $user_id], function ($message) use ($request) {
            $message->from(env('MAIL_FROM_ADDRESS'));
            $message->to($request->email); // Send email to the provided email address
            $message->subject('OTP Verification');
        });

        // Redirect to verification page with encrypted user_id
        return redirect()->route('user_verification', $user_id)->with('t-success', 'Enter your OTP code');
    }


    public function otp_submit(Request $request)
    {
        $userId = $request->user_id;
        $user = Package::find($userId);
        if ($user && $user->verification == $request->verification) {
            $user->verification_status = 1;
            $user->save();
            // Auth::loginUsingId($userId);

            return redirect()->route('thankyou',['package'=>$user->id])->with('t-success', 'You claim the Free Affiliation'); // Redirect to home after successful verification
        }
        $email = $user->email;

        $user_id = encrypt($request->user_id);
        // Mail::send('email.thankyou', ['user_id' => $user_id], function ($message) use ($email) {
        //     $message->from(env('MAIL_FROM_ADDRESS'));
        //     $message->to($email);
        //     $message->subject('Thank you');
        // });
        return redirect()->route('user_verification', $user_id)->with('t-error', 'Invalid Claiming code');
    }



    public function user_verification($user_id)
    {
        $user_id = decrypt($user_id);
        return view('verification', compact('user_id'));
    }


    public function code_verification(Request $request)
    {
        // Check if the user is logged in
        if (!Auth::check()) {
            return redirect()->route('login')->with('t-error', 'You need to log in first.');
        }

        // Find the user by their email
        $current_user = Package::where("email", $request->email)->first();

        if ($current_user) {
            if ($current_user->verification_status == 1) {
                // User is already verified, proceed to home or success page
                return redirect()->route('homepage')->with('t-success', 'You have already verified your code!');
            } else {
                // User is not verified, redirect to verification page with user_id
                $user_id = encrypt($current_user->id);
                return redirect()->route('user_verification', $user_id)->with('t-error', 'Please verify your account with the code sent to your email.');
            }
        } else {
            // User not found, redirect to create a new redeem code
            return redirect()->route('affiliate')->with('t-error', 'No code found for this email. Please create a new redeem code.');
        }
    }



    public function generateAffiliateLink()
    {
        if (Auth::check()) {
            $user = Auth::user();
            $user->referral_code = Str::random(10); // Generate unique referral code
            $user->save();

            $affiliateLink = route('register', ['ref' => $user->referral_code]);
            return view('affiliate_link', compact('affiliateLink'));
        } else {
            return redirect()->route('login')->with('t-error', 'You need to log in first.');
        }
    }

    public function register(Request $request)
    {
        $referralCode = $request->query('ref');
        $parent = User::where('referral_code', $referralCode)->first();
        return view('auth.register', compact('parent'));
    }

    public function storeUser(Request $request)
    {
        $parent_id = $request->input('parent_id');

        $user = User::create([
            // Other user fields
            'parent_id' => $parent_id,
            'referral_code' => Str::random(10),
        ]);

        Auth::login($user);

        return redirect()->route('homepage')->with('t-success', 'Welcome to our platform!');
    }


    public function thankyou() {
        if(isset($_GET['package'])){
            $package = Package::find($_GET['package']);
            return view('frontend.layout.thankyou')->with('package' , $package);
        }
    }
}
