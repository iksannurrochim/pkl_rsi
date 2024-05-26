<?php

namespace App\Http\Controllers;

use App\Models\penyelia;
use App\Models\instansi;
use App\Models\peserta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    function index(Request $request)
    {
        $katakunci = $request->katakunci;
        $jumlahbaris = 20;
        $instansis = instansi::pluck('nama', 'id');
        if(strlen($katakunci)){
            $data = peserta::where('id','like',"%$katakunci%")
                    ->orWhere('nama','like',"%$katakunci%")
                    ->orWhere('nim','like',"%$katakunci%")
                    ->paginate($jumlahbaris);
        }else{
            $data = peserta::orderBy('id', 'asc')->paginate($jumlahbaris);
        }
        $managers = $instansis->all();
        return view('peserta.index', compact('data', 'managers'));
        // return view ('admin');
        // echo "Halo, Selamat Datang";
        // echo "<h1>". Auth::user()->username ."</h1>";
        // echo "<a href='/logout'>Logout >></a>";
    }

    function operator()
    {
        return view ('peserta.create');
        // echo "Halo, Selamat Datang di Halaman Admin/Operator";
        // echo "<h1>". Auth::user()->username ."</h1>";
        // echo "<a href='/logout'>Logout >></a>";
    }

    function peserta()
    {
        echo "Halo, Selamat Datang di Halaman Peserta";
        echo "<h1>". Auth::user()->username ."</h1>";
        echo "<a href='/logout'>Logout >></a>";
    }

    function penyelia(Request $request)
    {
        $katakunci = $request->katakunci;
        $jumlahbaris = 20;
        if(strlen($katakunci)){
            $data = penyelia::where('id','like',"%$katakunci%")
                    ->orWhere('nama','like',"%$katakunci%")
                    ->orWhere('alamat','like',"%$katakunci%")
                    ->paginate($jumlahbaris);
        }else{
            $data = penyelia::orderBy('nip', 'asc')->paginate($jumlahbaris);
        }
        return view('penyelia.index')->with('data', $data);

        // echo "Halo, Selamat Datang di Halaman Penyelia";
        // echo "<h1>". Auth::user()->username ."</h1>";
        // echo "<a href='/logout'>Logout >></a>";
    }
}
