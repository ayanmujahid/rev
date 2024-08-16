<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class TwoFactorAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->user() && $request->user()->hasRole('admin')) {
            if (Session::has('2fa') && Session::get('2fa')['validated']) {
                return $next($request);
            }

            if (!$request->session()->has('2fa')) {
                // Generate OTP and send email
                $otp = Str::random(6);
                Session::put('2fa', ['otp' => $otp, 'validated' => false]);

                // Send OTP to specific email address
                Mail::send('email.otp', ['userName' => 'Admin', 'otp' => $otp], function ($message) {
                    $message->to('arsalan.mazhar@flowtechnologies.io')
                            ->subject('Your OTP Code');
                });

                // Redirect to OTP verification page
                return redirect()->route('2fa.verify');
            }
        }

        return $next($request);
    }
}
