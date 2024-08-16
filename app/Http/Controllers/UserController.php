<?php

namespace App\Http\Controllers;


use Session;
use Exception;
use App\Models\User;

use App\Helper\Helper;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Validator;
use App\Models\Password_resets;
use App\Models\Schedule;
use App\Models\Product;
use App\Models\Time;





use App\Models\ProductCategory;


use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;

use Illuminate\Support\Facades\File;


use Yajra\DataTables\DataTables;

use Mail;
use DB;
use Carbon\Carbon;

class UserController extends Controller
{


    
public function forget_password()
    {
        return view('forgot-password')->with('title', 'Recovrey');
    }
public function thankyou()
    {
        return view('thankyou')->with('title', 'thankyou');
    }
    
    public function forget_password_submit(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users',
        ]);
        $token = Str::random(64);

        DB::table('password_resets')->insert([
            'email' => $request->email,
            'token' => $token,
            'created_at' => Carbon::now()
        ]);

        Mail::send('email/reset-password', ['token' => $token, 'request' => $request], function ($message) use ($request) {
            $message->from(env('MAIL_FROM_ADDRESS'));
            $message->to($request->email);
            $message->subject('Reset Password');
        });

        return redirect()->route('homepage')->with('t-success', 'We have e-mailed your password reset link!');
    }

    public function forget_password_token($token)
    {
        $reset_email =  password_resets::where('token', $token)->first();
        if ($reset_email != null) {

            return view('forgot-password-form', ['token' => $token, 'email' => $reset_email])->with(compact('reset_email'))->with('title', 'Recovery');
        } else {
            return redirect()->route('homepage')->with('t-error', 'Inavlid Token');
        }
    }


    public function forget_password_reset(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users',
            'password' => 'required',
        ]);

        $updatePassword = DB::table('password_resets')->where([
            'email' => $request->email,
            'token' => $request->token
        ])->latest()->first();

        if (!$updatePassword) {
            return back()->withInput()->with('t-error', 'Invalid token!');
        }

        $user = User::where('email', $request->email)->update(['password' => Hash::make($request->password)]);
        DB::table('password_resets')->where(['email' => $request->email])->delete();
        return redirect()->route('homepage')->with('t-success', 'Your password has been changed!');
    }
    
    
    
     public function update_booking(Request $request)
    {
        // Validate the request
        $request->validate([
            // 'schedule_id' => 'required|exists:schedules,id',
            'status' => 'required|integer'
        ]);

        // Find the schedule by ID
        $schedule = Schedule::find($request->schedule_id);

        // Update the status to 1
        $schedule->status = $request->status;
        $schedule->save();

        // Redirect back with a success message
        return redirect('/')->with('success', 'Schedule status updated successfully.');
    }
    
    
    
public function update_time_booking(Request $request)
{
    // Validate the request
   

    // Find the schedule and time slot by their ids

    $timeSlot = Time::find($request->schedule_id);

    // Check if the time slot was found
    if (!$timeSlot) {
        return redirect('/')->with('error', 'Time slot not found for the provided time_slot_id.');
    }

    // Update the status and user details for the selected time slot
    $timeSlot->status = $request->status;
    $timeSlot->name = $request->name;
    $timeSlot->email = $request->email;
    $timeSlot->phone = $request->phone;
    $timeSlot->save();

    // Send confirmation email with booking details
    Mail::send('email/booking', [
      
        'timeSlot' => $timeSlot,
        'name' => $request->name,
        'email' => $request->email,
        'phone' => $request->phone,
        'meeting_date' => $request->meeting_date
    ],  function ($message) {
        $message->from(env('MAIL_FROM_ADDRESS'));
        $message->to(env('MAIL_TO_TEST')); // Send email to the admin
        $message->subject('Meeting Schedule Confirmation');
    });

    // Redirect back with a success message
    return redirect('/meeting-schedule')->with('t-success', 'Time slot status updated successfully.');
}



public function meeting_schedule() {
    
    return view('thankyoubook');
}





// public function product_category($id = null) {
//     $categories = ProductCategory::where('status', 'active')->get();
//     $selected_category = $id ?? request()->input('category');
    
//     if ($selected_category) {
//         $latest_product = Product::where('category_id', $selected_category)->get();
//     } else {
//         $latest_product = Product::all(); // or any other logic for default products
//     }

//     return view('frontend.layout.product-category', compact('latest_product', 'categories', 'selected_category'));
// }

public function product_category($id = null) {
    // Fetch all active categories
    $categories = ProductCategory::where('status', 'active')->get();
    
    // Determine the selected category ID
    $selected_category_id = $id ?? request()->input('category');
    
    // Initialize the selected category object
    $selected_category = null;
    
    if ($selected_category_id) {
        // Fetch the selected category by ID or slug
        $selected_category = ProductCategory::find($selected_category_id);
        
        // Fetch products belonging to the selected category
        $latest_product = Product::where('category_id', $selected_category_id)->get();
    } else {
        // Fetch all products if no category is selected
        $latest_product = Product::all();
    }
    
    return view('frontend.layout.product-category', compact('latest_product', 'categories', 'selected_category'));
}



public function showForm()
{
    return view('auth.2fa');
}

public function verifyOtp(Request $request)
{
    $request->validate([
        'otp' => 'required|size:6'
    ]);

    $sessionOtp = Session::get('2fa')['otp'];
    if ($request->input('otp') === $sessionOtp) {
        Session::put('2fa.validated', true);
        return redirect()->route('dashboard');
    }

    return redirect()->route('2fa.verify')->withErrors(['otp' => 'Invalid OTP']);
}
    
    
    

}