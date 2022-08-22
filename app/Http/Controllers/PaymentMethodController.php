<?php

namespace App\Http\Controllers;

use App\Models\PaymentMethod;
use Illuminate\Http\Request;
use App\PaymentGateways\PaymentGatewayFactory;
use Illuminate\Support\Str;

class PaymentMethodController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        return view('Dashboard.Payment-Methods.index', [
            'payment_methods' => PaymentMethod::latest()->paginate()
        ]);
    }


    public function edit($id)
    {
        $method             = PaymentMethod::findOrFail($id);
        $getPaymentGetWay   = PaymentGatewayFactory::create($method->slug);

        return view('Dashboard.Payment-Methods.edit', [
            'method'   => $method,
            'options'   => $getPaymentGetWay->formOptions()
        ]);
    }


    public function update(Request $request,  $id)
    {
        $request->merge([
            'slug' => Str::slug($request->post('name'))
        ]);
        $request->validate([
            'name'        => "required|string|between:4,40|unique:payment_methods,name,$id",
            'description' => 'nullable|string',
        ]);
        $payment = PaymentMethod::findOrFail($id);
        $payment->update($request->all());
        return redirect()->back()->with('success' , 'Successfully Updated Payment Method');
    }
}
