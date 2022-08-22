<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function checkLogin(Request $request)
    {
        $request->validate([
            'email'    => 'required|exists:users,email|email',
            'password' => 'required|string'
        ]);

        $user = $request->only(['email' , 'password']);

        if(Auth::guard('web')->attempt($user)){
            return redirect()->route('payment.methods.all');
        }else{
            return redirect()->back()->with('error' , 'Wrong email or password');
        }
    }
}
