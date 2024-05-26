<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }else{
            return view('auth.login', [
                'title' => 'Login'
            ]);
        }

    }

    public function authenticate(Request $request){
        $credentials = $request -> validate([
            'identifier' => ['required', 'string'],
            'password' => ['required'],
        ]);

        if(filter_var($credentials['identifier'], FILTER_VALIDATE_EMAIL)){
            $credentials['email']=$credentials['identifier'];
            unset($credentials['identifier']);
        }
        else{
            $credentials ['nomor_id']=$credentials['identifier'];
            unset($credentials['identifier']);
        }

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $role = Auth::user()->role;
            return redirect()->route('dashboard', ['role' => $role]);
        }

        return back()->withErrors([
            'loginError' => 'Login Gagal',
        ])->withInput($request->only('identifier'));

        // return back()->withErrors([
        //     'loginError'=>'Login gagal',
        // ])->onlyInput('loginError');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
