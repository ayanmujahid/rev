<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Subscribe;
use Exception;
use Illuminate\Http\Request;

class SubscribesController extends Controller {
    public function storeEmail(Request $request) {
        $request->validate([
            'email' => 'required|email',
        ]);

        try {
            $email        = new Subscribe;
            $email->email = $request->email;
            $email->save();

            return redirect()->route('thank-you')->with('t-success', 'You Have Successfully Subscribe to our Revival Entertainment');
        } catch (Exception $e) {
            return back()->with('t-error', 'You already subscribed our Revival Entertainment');
        }
    }
}
