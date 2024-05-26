<?php

namespace App\Http\Controllers;

use App\Models\instansi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class instansiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $katakunci = $request->katakunci;
        $jumlahbaris = 20;
        if(strlen($katakunci)){
            $data = instansi::where('id','like',"%$katakunci%")
                    ->orWhere('nama','like',"%$katakunci%")
                    ->paginate($jumlahbaris);
        }else{
            $data = instansi::orderBy('id', 'asc')->paginate($jumlahbaris);
        }
        return view('instansi.index')->with('data', $data);
        // return 'Hi';
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('instansi.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Session::flash('id', $request->id);
        Session::flash('nama', $request->nama);
        Session::flash('alamat', $request->alamat);

        $request->validate([
            // 'id'=>'required|numeric|unique:instansis,id',
            'nama'=>'required',
            'alamat'=>'required',
        ],[
            // 'id.required'=>'ID wajib diisi',
            // 'id.numeric'=>'ID wajib berupa angka',
            // 'id.unique'=>'ID yang diisikan sudah ada',
            'nama.required'=>'Nama wajib diisi',
            'alamat.required'=>'Alamat wajib diisi',
        ]);

        $data = [
            // 'id'=>$request->id,
            'nama'=>$request->nama,
            'alamat'=>$request->alamat,
            
        ];

        instansi::create($data);
        return redirect()->to('instansi')->with('success', 'Berhasil menambahkan data');
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
        $data = instansi::where('id',$id)->first();
        return view('instansi.edit')->with('data', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            
            'nama'=>'required',
            'alamat'=>'required',
        ],[
            
            'nama.required'=>'Nama wajib diisi',
            'alamat.required'=>'Alamat wajib diisi',

        ]);
        $data = [
            
            'nama'=>$request->nama,
            'alamat'=>$request->alamat,
        ];
        instansi::where('id',$id)->update($data);
        return redirect()->to('instansi')->with('success', 'Berhasil mengupdate data');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        instansi::where('id',$id)->delete();
        return redirect()->to('instansi')->with('success', 'Berhasil menghapus data');
    }
}
