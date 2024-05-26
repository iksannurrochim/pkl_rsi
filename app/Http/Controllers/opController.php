<?php

namespace App\Http\Controllers;

use App\Models\operator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class opController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $katakunci = $request->katakunci;
        $jumlahbaris = 4;
        if(strlen($katakunci)){
            $data = operator::where('id','like',"%$katakunci%")
                    ->orWhere('nama','like',"%$katakunci%")
                    ->orWhere('email','like',"%$katakunci%")
                    ->paginate($jumlahbaris);
        }else{
            $data = operator::orderBy('id', 'asc')->paginate($jumlahbaris);
        }
        return view('operator.index')->with('data', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('operator.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Session::flash('id', $request->id);
        Session::flash('nama', $request->nama);
        Session::flash('email', $request->email);
        Session::flash('hp', $request->hp);

        $request->validate([
            'id'=>'required|numeric|unique:penyelia,id',
            'nama'=>'required',
            'email'=>'required',
            'hp'=>'required',
        ],[
            'id.required'=>'NIP wajib diisi',
            'id.numeric'=>'NIP wajib berupa angka',
            'id.unique'=>'NIP yang diisikan sudah ada',
            'nama.required'=>'Nama wajib diisi',
            'email.required'=>'Email wajib diisi',
            'hp.required'=>'No HP wajib diisi',
        ]);

        $data = [
            'id'=>$request->id,
            'nama'=>$request->nama,
            'email'=>$request->email,
            'hp'=>$request->hp,
            
        ];

        operator::create($data);
        return redirect()->to('operator')->with('success', 'Berhasil menambahkan data');
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
        $data = operator::where('id',$id)->first();
        return view('operator.edit')->with('data', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            
            'id'=>'required',
            'nama'=>'required',
            'email'=>'required',
            'hp'=>'required',
        ],[
            
            'id.required'=>'NIP wajib diisi',
            'nama.required'=>'Nama wajib diisi',
            'email.required'=>'Email wajib diisi',
            'hp.required'=>'No HP wajib diisi',

        ]);
        $operator = [
            
            'id'=>$request->id,
            'nama'=>$request->nama,
            'email'=>$request->email,
            'hp'=>$request->hp,
        ];
        operator::where('id',$id)->update($operator);
        return redirect()->to('operator')->with('success', 'Berhasil mengupdate data');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        operator::where('id',$id)->delete();
        return redirect()->to('operator')->with('success', 'Berhasil menghapus data');
    }
}
