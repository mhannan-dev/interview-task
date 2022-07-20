<?php

namespace App\Http\Controllers;

use Stripe\Charge;
use Stripe\Stripe;
use App\CPU\Helpers;
use App\Models\User;
use App\Mail\NotifyMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Laravel\Passport\TokenRepository;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class StripeController extends Controller
{
    public function stripePost(Request $request)
    {
        // Stripe::setApiKey(env('STRIPE_SECRET'));
        // Charge::create ([
        //         "amount" => 100*100,
        //         "currency" => "USD",
        //         "source" => $request->stripeToken,
        //         "description" => "This is test payment",
        // ]);
        // Session::flash('success', 'Payment Successful!');
        // return back();

        try {
            \Stripe\Charge::create([
                'amount' => 100 * 100,
                'currency' => 'USD',
                "source" => $request->stripeToken,
                'description' => 'Payment',
            ]);

        return back()->with('success_message', 'Thank you! Your payment has been successfully accepted!');
        } catch (Exception $e) {

        }
    }
}
