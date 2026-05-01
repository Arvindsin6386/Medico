<?php

namespace App\Http\Controllers\Admin\Auth;
use Illuminate\Support\Facades\Auth;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LogoutController extends Controller
{
    public function logout(){
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login')->with('success','Logged Out Successfully');
    }
}
