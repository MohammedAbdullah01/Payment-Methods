<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\PaymentMethod;
use App\PaymentGateways\PaymentGatewayFactory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckOutController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        return view('checkout.index', [
            'methods' => PaymentMethod::active()->get()
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'payment_method' => 'required|exists:payment_methods,slug'
        ]);

        $getway = PaymentGatewayFactory::create($request->post('payment_method'));

        $order =  Order::create([
            'total' => 500,
            'currency_code' => 'USD'
        ]);

        $user = Auth::user();

        return $getway->create($order, $user);
    }
}
