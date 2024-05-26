<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\penyelia;
use App\Models\instansi;
use App\Models\nilai;
use App\Models\peserta;
use App\Models\entry_progres;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Illiminate\validation\Rule;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;


class PesertaEditController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $instansis = Instansi::all();
        $penyelia = Penyelia::all();
        $peserta = Peserta::where('nim', Auth::user()->nomor_id)->first();

        return view('edit_profil.index', [
            'title' => 'Edit Profile'
        ])->with(compact('peserta', 'instansis', 'penyelia'));
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

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // $request->validate([
        //     'fileProfile' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        //     'instansi_id' => 'required|exists:instansi,id',
        //     'nama' => 'required',
        //     'nim' => 'required',
        //     'jurusan' => 'required',
        //     'hp' => 'required',
        //     'email' => 'required|email|unique:users,email,' . $id . ',nomor_id',
        //     'status' => 'required',
        // ], [
        //     'fileProfile.image' => 'Foto profile harus berupa gambar',
        //     'fileProfile.mimes' => 'Format gambar tidak valid. Hanya diperbolehkan jpeg,jpg,png,gif.',
        //     'fileProfile.max' => 'Ukuran gambar terlalu besar. Maksimal 2 MB',
        //     'instansi_id.required' => 'Instansi wajib diisi',
        //     'nama.required' => 'Nama wajib diisi',
        //     'nim.required' => 'NIM wajib diisi',
        //     'jurusan.required' => 'Jurusan wajib diisi',
        //     'hp.required' => 'Nomor HP wajib diisi',
        //     'email.required' => 'Email wajib diisi',
        //     'email.email' => 'Email tidak valid',
        //     'email.unique' => 'Email sudah terdaftar',
        //     'status.required' => 'Status wajib diisi',
        // ]);

        // $peserta = Peserta::where('nim', $id)->first();
        // $pesertaData = [
        //     'instansi_id' => $request->instansi_id,
        //     'nama' => $request->nama,
        //     'jurusan' => $request->jurusan,
        //     'hp' => $request->hp,
        //     'status' => $request->status,
        // ];

        // if ($request->hasFile('fileProfile')) {
        //     if ($peserta->foto) {
        //         $oldPath = public_path('files/Profile/' . $peserta->foto);
        //         if (File::exists($oldPath)) {
        //             File::delete($oldPath);
        //         }
        //     }

        //     $file = $request->file('fileProfile');
        //     $fileName = $id . '_' . time() . '.' . $file->getClientOriginalExtension();
        //     $file->move(public_path('files/Profile'), $fileName);
        //     $pesertaData['foto'] = $fileName;
        // }

        // $peserta->update($pesertaData);

        // User::where('nomor_id', $id)->update([
        //     'nama' => $request->nama,
        //     'email' => $request->email,
        // ]);

        // return redirect()->route('dashboard')->with('success', 'Profil peserta berhasil disimpan');
    
        $request->validate([
            'fileProfile' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'nama' => 'required|string',
            'nim' => 'required',
            'instansi_id' => 'required|exists:instansi,id',
            'jurusan' => 'required',
            'hp' => 'required|numeric',
            'email' => 'required|email|max:255',
            'status' => 'required',
        ], [
            'fileProfile.image' => 'Foto profile harus berupa gambar.',
            'fileProfile.mimes' => 'Format gambar tidak valid. Hanya diperbolehkan: jpeg, png, jpg, gif.',
            'fileProfile.max' => 'Ukuran gambar terlalu besar. Maksimal 2 MB.',
            'nama.required' => 'Nama harus diisi.',
            'nim.required' => 'NIM / NIS harus diisi.',
            'instansi_id.required' => 'Instansi wajib diisi',
            'jurusan.required' => 'Jurusan harus diisi.',
            'email.required' => 'Email harus diisi.',
            'email.email' => 'Email tidak valid.',
            'hp.required' => 'Handphone harus diisi.',
            'status.required' => 'Status harus diisi.',
        ]);

        // Cek email unik
        $existingUser = User::where('email', $request->email)->where('nomor_id', '!=', $id)->first();
        if ($existingUser) {
            return back()->withErrors(['email' => 'Email sudah terdaftar.'])->withInput();
        }

        // Update to DB
        $peserta = Peserta::where('nim', $id)->first(); 
        $pesertaData = [
            'nama' => $request->nama,
            'hp' => $request->hp,
            // 'email' => $request->email,
            'instansi_id' => $request->instansi_id,
            'jurusan' => $request->jurusan,
        ];

        // Check if there is a new profile picture
        if ($request->hasFile('fileProfile')) {
            // Delete old profile picture if exists
            if ($peserta->foto) {
                $oldPath = public_path('files/Profile/' . $peserta->foto);
                if (File::exists($oldPath)) {
                    File::delete($oldPath);
                }
            }

            // Store new profile picture
            $file = $request->file('fileProfile');
            $fileName = $id . '_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('files/Profile'), $fileName);
            $pesertaData['foto'] = $fileName;
        }

        DB::table('peserta')->where('nim', $id)->update($pesertaData);
        
        User::where('nomor_id', $id)->update([
            'username' => $request->nama,
            'email' => $request->email,
        ]);

        return redirect()->route('dashboard')->with('success', 'Profil peserta berhasil diupdate.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
