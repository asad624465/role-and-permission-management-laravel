<?php

namespace App\Http\Controllers\Backend\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    use AuthenticatesUsers;
    protected $redirectTo = RouteServiceProvider::ADMIN_HOME;
    /*=======================================================================================
                                        Display Login form
    =======================================================================================*/
    public function loginForm()
    {
        return  view('backend.pages.auth.adminLogin');
    }
    /*=======================================================================================
                                        Admin Login function
    =========================================================================================*/
    public function login(Request $request)
    {
        $this->validate($request,[
            'email'=>'required|email|max:50',
            'password'=>'required',
        ]);
        if (Auth::guard('admin')->attempt(['email'=>$request->email,'password'=>$request->password,'status'=>1])) {
            session()->flash('login_success','Successfully Login');
            return redirect()->intended(route('admin.dashboard'));
        } else {
            session()->flash('login_error','Successfully Login');
            return back();
        }
        
    }
    /*=======================================================================================
                                        Admin logout function
    =========================================================================================*/
    public function logout()
    {
        Auth::guard('admin')->logout(); 
        return redirect()->route('admin.login');   
    }
}
