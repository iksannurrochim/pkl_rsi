<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SesiController extends Controller
{
    // function index()
    // {
    //     return view('auth.login');
    // }
    // function login(Request $request)
    // {
    //     $request->validate([
    //         'email'=>'required',
    //         'password'=>'required'
    //     ],[
    //         'email.required'=>'Email wajib diisi',
    //         'password.required'=>'Password wajib diisi',
    //     ]);

    //     $infoLogin = [
    //         'email'=>$request->email,
    //         'password'=>$request->password,
    //     ];

    //     if(Auth::attempt($infoLogin)){
    //         if (Auth::user()->roleid == 1){
    //             return redirect('admin/operator');
    //         }elseif (Auth::user()->roleid == 2){
    //             return redirect('admin/peserta');
    //         }elseif (Auth::user()->roleid == 3){
    //             return redirect('admin/penyelia');
    //         }
    //     }else{
    //         return redirect('')->withErrors('Email dan password yang dimasukkan tidak sesuai')->withInput();
    //     };
    // }

    // function logout()
    // {
    //     Auth::logout();
    //     return redirect('');
    // }
}
