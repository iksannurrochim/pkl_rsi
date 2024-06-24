<?php

namespace App\Http\Controllers;

use App\Models\penyelia;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class penyeliaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = User::where('nomor_id', Auth::user()->nomor_id)->first();
        $katakunci = $request->katakunci;
        $jumlahbaris = 20;
        if(strlen($katakunci)){
            $data = penyelia::where('id','like',"%$katakunci%")
                    ->orWhere('nama','like',"%$katakunci%")
                    ->orWhere('email','like',"%$katakunci%")
                    ->paginate($jumlahbaris);
        }else{
            $data = penyelia::orderBy('id', 'asc')->paginate($jumlahbaris);
        }
        return view('penyelia.index',compact('user', 'data'));
        // return "Hi";
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = User::where('nomor_id', Auth::user()->nomor_id)->first();
        return view('penyelia.create',compact('user'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Session::flash('id', $request->id);
        Session::flash('nama', $request->nama);
        Session::flash('email', $request->email);

        $request->validate([
            'id'=>'required',
            'nama'=>'required',
            'email'=>'required',
        ],[
            'id.required'=>'NIP wajib diisi',
            'id.numeric'=>'NIP wajib berupa angka',
            'id.unique'=>'NIP yang diisikan sudah ada',
            'nama.required'=>'Nama wajib diisi',
            'email.required'=>'Email wajib diisi',
        ]);

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        User::insert([
        'nomor_id' => $request->id,
        'username' => $request->nama,
        'email' => $request->email,
        'password' => bcrypt($request->id),
        'role' => '3'
        ]);
        Penyelia::insert([
            'id' => $request->id,
            'nama' => $request->nama,
            'email' => $request->email,
        ]);

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // $data = [
        //     'id'=>$request->id,
        //     'nama'=>$request->nama,
        //     'email'=>$request->email,
            
        // ];

        // penyelia::create($data);
        return redirect()->to('penyelia')->with('success', 'Data berhasil ditambahkan');;
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
        $user = User::where('nomor_id', Auth::user()->nomor_id)->first();
        $data = penyelia::where('id',$id)->first();
        return view('penyelia.edit', compact('user', 'data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            
            
            'nama'=>'required',
            'email'=>'required',
        ],[
            
            
            'nama.required'=>'Nama wajib diisi',
            'email.required'=>'Email wajib diisi',

        ]);

        // Lakukan pembaruan data peserta
        penyelia::where('id', $id)->update([
            // 'id' => $request->id,
            'nama' => $request->nama,
            'email' => $request->email,
        ]); 
    
        // Buat array data baru untuk pembaruan user
        $userData = [
            'username' => $request->nama, // Ubah username sesuai dengan nama peserta
            'email' => $request->email,
        ];
    
        // Jika password tidak kosong, tambahkan ke data user
        if ($request->filled('password')) {
            $userData['password'] = bcrypt($request->password);
        }
    
        // Lakukan pembaruan data user
        User::where('nomor_id', $id)->update($userData);


        // $penyelia = [
            
        //     'id'=>$request->id,
        //     'nama'=>$request->nama,
        //     'email'=>$request->email,
        // ];
        // penyelia::where('id',$id)->update($penyelia);
        return redirect()->to('penyelia')->with('success', 'Berhasil mengupdate data');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        penyelia::where('id',$id)->delete();
        user::where('nomor_id',$id)->delete();
        return response()->json(['success' => true]);

        // penyelia::where('id',$id)->delete();
        // return redirect()->to('penyelia')->with('success', 'Berhasil menghapus data');
    }

}
