<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\instansi;
use App\Models\peserta;
use Illuminate\Support\Facades\Session;

class listPeserta extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $katakunci = $request->katakunci;
        $jumlahbaris = $request->session()->get('jumlahbaris', 10);

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

        return view('uspenyelia.index', compact('data', 'managers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $instansis = instansi::all();
        $data = peserta::where('id',$id)->first();
        return view('uspenyelia.profilpeserta', compact('data', 'instansis'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
