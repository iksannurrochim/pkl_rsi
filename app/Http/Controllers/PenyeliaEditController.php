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
use RealRashid\SweetAlert\Facades\Alert;
use Illiminate\validation\Rule;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

use Illuminate\Http\Request;

class PenyeliaEditController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $instansis = Instansi::all();
        $peserta = Peserta::all();
        $penyelia = Penyelia::where('id', Auth::user()->nomor_id)->first();

        return view('edit_profil_penyelia.index', [
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'fileProfile' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'nama' => 'required|string',
            'id' => 'required',
            'hp' => 'required|numeric',
            'email' => 'required|email|max:255',
        ], [
            'fileProfile.image' => 'Foto profile harus berupa gambar.',
            'fileProfile.mimes' => 'Format gambar tidak valid. Hanya diperbolehkan: jpeg, png, jpg, gif.',
            'fileProfile.max' => 'Ukuran gambar terlalu besar. Maksimal 2 MB.',
            'nama.required' => 'Nama harus diisi.',
            'id.required' => 'NIM / NIS harus diisi.',
            'email.required' => 'Email harus diisi.',
            'email.email' => 'Email tidak valid.',
            'hp.required' => 'Handphone harus diisi.',
        ]);

        // Cek email unik
        $existingUser = User::where('email', $request->email)->where('nomor_id', '!=', $id)->first();
        if ($existingUser) {
            return back()->withErrors(['email' => 'Email sudah terdaftar.'])->withInput();
        }

        // Update to DB
        $penyelia = Penyelia::where('id', $id)->first(); 
        $penyeliaData = [
            'nama' => $request->nama,
            'hp' => $request->hp,
            'email' => $request->email,
        ];

        // Check if there is a new profile picture
        if ($request->hasFile('fileProfile')) {
            // Delete old profile picture if exists
            if ($penyelia->foto) {
                $oldPath = public_path('files/Profile/' . $penyelia->foto);
                if (File::exists($oldPath)) {
                    File::delete($oldPath);
                }
            }

            // Store new profile picture
            $file = $request->file('fileProfile');
            $fileName = $id . '_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('files/Profile'), $fileName);
            $penyeliaData['foto'] = $fileName;
        }

        DB::table('penyelia')->where('id', $id)->update($penyeliaData);
        
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
