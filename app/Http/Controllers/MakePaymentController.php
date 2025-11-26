<?php

namespace App\Http\Controllers;

use App\Models\UserPayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class MakePaymentController extends Controller
{
    // payment page
    public function index()
    {
        $userPayment = Auth::user()->userPayment;
        return Inertia::render('make-payment/Index', [
            'userPayment' => $userPayment
        ]);
    }

    // make payment
    public function makePayment(Request $request)
    {
        $request->validate([
            'voucher_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $voucher_image = $request->file('voucher_image');
        $voucher_image_name = time() . '.' . $voucher_image->getClientOriginalName();
        $voucher_image->move(public_path('images'), $voucher_image_name);

        UserPayment::create([
            'user_id' => Auth::id(),
            'voucher_image' => $voucher_image_name,
            'payment_status' => 'pending',
        ]);

        return redirect()->back()->with('success', 'Payment made successfully');
    }
}
