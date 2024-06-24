<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\instansi;
use App\Models\penyelia;
use App\Models\peserta;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class PesertaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = User::where('nomor_id', Auth::user()->nomor_id)->first();
        $katakunci = $request->katakunci;
        $jumlahbaris = $request->session()->get('jumlahbaris', 20);

        $instansiManagers = instansi::pluck('nama', 'id');

        if(strlen($katakunci)){
            $data = peserta::where('id','like',"%$katakunci%")
                    ->orWhere('nama','like',"%$katakunci%")
                    ->orWhere('nim','like',"%$katakunci%")
                    ->paginate($jumlahbaris);
        }else{
            $data = peserta::orderBy('nim', 'asc')->paginate($jumlahbaris);
        }


        return view('peserta.index', compact('data', 'instansiManagers', 'user'));
        // return view('peserta.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = User::where('nomor_id', Auth::user()->nomor_id)->first();
        $instansis = instansi::all();
        $penyelia = penyelia::all();
        // return view('peserta.create');
        return view('peserta.create', compact('instansis', 'penyelia', 'user'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $peserta = peserta::all();
        $managerCodes = $peserta->pluck('instansi_id')->unique()->toArray();
        $managers = peserta::whereIn('nim', $managerCodes)->pluck('nama', 'nim');

        Session::flash('nim', $request->nim);
        Session::flash('instansi_id', $request->instansi_id);
        Session::flash('nama', $request->nama);
        Session::flash('jurusan', $request->jurusan);
        Session::flash('alamat', $request->alamat);
        Session::flash('tanggal_lahir', $request->tanggal_lahir);
        // Session::flash('lama_kegiatan', $request->lama_kegiatan);
        Session::flash('hp', $request->hp);
        Session::flash('foto', $request->foto);
        Session::flash('id_penyelia', $request->id_penyelia);

        $request->validate([
            'nim'=>'required|unique:peserta,nim',
            'instansi_id'=>'required',
            'nama'=>'required',
            'jurusan'=>'required',
            'alamat'=>'required',
            'tanggal_lahir'=>'required',
            // 'lama_kegiatan'=>'required',
            'hp'=>'required',
            'email'=>'required|email',
            // 'foto'=>'required',
            'id_penyelia'=>'required',
        ],[
            'nim.required'=>'NIM wajib diisi',
            // 'nim.numeric'=>'ID wajib berupa angka',
            'nim.unique'=>'NIM yang diisikan sudah ada',
            'instansi_id.required'=>'Instansi wajib diisi',
            'nama.required'=>'Nama wajib diisi',
            // 'instansi_id.required'=>'Asal Instansi wajib diisi',
            'jurusan.required'=>'Jurusan wajib diisi',
            'alamat.required'=>'No HP wajib diisi',
            'tanggal_lahir.required'=>'Tanggal lahir wajib diisi',
            // 'lama_kegiatan.required'=>'Lama Kegiatan wajib diisi',
            'hp.required'=>'Lama magang wajib diisi',
            'id_penyelia.required'=>'Penyelia wajib diisi',
        ]);

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        User::insert([
        // 'id' => $request->id,
        'nomor_id' => $request->nim,
        'username' => $request->nama,
        'email' => $request->email,
        'password' => bcrypt($request->nim),
        'role' => '1'
        ]);
        Peserta::insert([
            'nim' => $request->nim,
            'instansi_id' => $request->instansi_id,
            'nama' => $request->nama,
            'jurusan' => $request->jurusan,
            'alamat' => $request->alamat,
            'tanggal_lahir' => $request->tanggal_lahir,
            // 'lama_kegiatan' => $request->lama_kegiatan,
            'hp' => $request->hp,
            'foto' => $request->foto,
            'id_penyelia' => $request->id_penyelia,
            'status' => 'Aktif',
        ]);

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // $data = [
        //     'id'=>$request->id,
        //     'nama'=>$request->nama,
        //     'nim'=>$request->nim,
        //     'instansi_id'=>$request->instansi_id,
        //     'alamat'=>$request->alamat,
        //     'hp'=>$request->hp,
        //     'tanggal_lahir'=>$request->tanggal_lahir,
        //     'lama_kegiatan'=>$request->lama_kegiatan,
        //     'jurusan'=>$request->jurusan,
        // ];

        // peserta::create($data);
        return redirect()->to('peserta')->with('success', 'Berhasil menambahkan data');
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
        $instansis = instansi::all();
        $penyelia = penyelia::all();

        $data = peserta::where('nim', $id)->first();
        return view('peserta.edit', compact('data', 'instansis', 'penyelia', 'user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'instansi_id' => 'required|exists:instansi,id', // Pastikan instansi_id valid dan ada di tabel instansis
            'nama' => 'required',
            'jurusan' => 'required',
            'alamat' => 'required',
            'tanggal_lahir' => 'required',
            'hp' => 'required',
            'email' => 'required|email|unique:user,email,' . $id . ',nomor_id', // Cek unique email di tabel users
            'id_penyelia' => 'required|exists:penyelia,id', // Pastikan id_penyelia valid dan ada di tabel penyelias
        ], [
            'instansi_id.required' => 'Instansi wajib diisi',
            'nama.required' => 'Nama wajib diisi',
            'jurusan.required' => 'Jurusan wajib diisi',
            'alamat.required' => 'Alamat wajib diisi',
            'tanggal_lahir.required' => 'Tanggal lahir wajib diisi',
            // 'lama_kegiatan.required' => 'Lama Kegiatan wajib diisi',
            'hp.required' => 'Nomor HP wajib diisi',
            'email.required' => 'Email wajib diisi',
            'email.email'=> 'Email Tidak valid', 
            'email.unique' => 'Email sudah terdaftar',
            'id_penyelia.required' => 'Penyelia wajib diisi',
        ]);
    
        // Lakukan pembaruan data peserta
        Peserta::where('nim', $id)->update([
            'instansi_id' => $request->instansi_id,
            'nama' => $request->nama,
            'jurusan' => $request->jurusan,
            'alamat' => $request->alamat,
            'tanggal_lahir' => $request->tanggal_lahir,
            // 'lama_kegiatan' => $request->lama_kegiatan,
            'hp' => $request->hp,
            'foto' => $request->foto,
            'id_penyelia' => $request->id_penyelia,
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
    
        // Redirect kembali ke halaman peserta setelah berhasil
        return redirect()->to('peserta')->with('success', 'Berhasil mengupdate data');
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $nim)
    {
        peserta::where('nim',$nim)->delete();
        user::where('nomor_id',$nim)->delete();
        return redirect()->route('peserta.index')->with('delete', 'Berhasil menghapus data');
    }
}
