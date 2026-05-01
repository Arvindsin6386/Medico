<?php

namespace App\Http\Controllers\Admin\Auth;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
        // if (Auth::guard('admin')->attempt([
        //     'email' => $request->email,
        //     'password' => $request->password
        // ])) {

        //     return redirect()->route('admin.dashboard')->with('success', 'Login Successfully');
        // }

        if (Auth::guard('admin')->attempt([
            'email' => $request->email,
            'password' => $request->password
        ], false)); {
            return redirect()->route('admin.dashboard')->with('success', 'Login Successfully');
        }


        return back()->with('error', 'Invalid credentials');
    }
}
