<?php

namespace App\Http\Controllers;

use App\Models\entry_progres;
use App\Models\user;
use App\Models\peserta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class progesPesertaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // $id_penyelia = request()->input('id_penyelia'); // Dapatkan nilai nim_peserta dari request jika tersedia
        $peserta = Peserta::where('nim', Auth::user()->nomor_id)->first();
        return view('progres.create', [
            'title' => 'Tambah Progres'
        ])->with(compact('peserta'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required',
            'progres' => 'required',
            'keterangan' => 'required',
        ], [
            'tanggal.required' => 'Tanggal wajib diisi',
            'progres.required' => 'Kegiatan yang terlaksana wajib diisi',
            'keterangan.required' => 'Keterangan wajib diisi',
        ]);
    
        // Dapatkan NIM peserta yang sedang login
        $nim_peserta = auth()->user()->nomor_id;
    
        // Pastikan nama kolom pada model Nilai sesuai dengan kolom pada tabel di database
        entry_progres::create([
            'tanggal' => $request->tanggal,
            'progres' => $request->progres,
            'keterangan' => $request->keterangan,
            'nim_peserta' => $nim_peserta,
            'status' => 'Belum',
        ]);
    
        // Redirect ke halaman progres peserta
        return redirect()->route('uspeserta.progres')->with('success', 'Berhasil menambahkan data');
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
        // Temukan entri progres berdasarkan ID
        $progres = entry_progres::find($id);
        $peserta = Peserta::where('nim', Auth::user()->nomor_id)->first();

        if (!$progres) {
            return redirect()->route('uspeserta.progres')->with('error', 'Data progres tidak ditemukan');
        }

        // Kirim data progres ke dalam view editprogres.blade.php
        return view('uspeserta.editprogres', compact('progres', 'peserta'));
            // return view('uspeserta.editprogres');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'tanggal' => 'required',
            'progres' => 'required',
            'keterangan' => 'required',
        ], [
            'tanggal.required' => 'Tanggal wajib diisi',
            'progres.required' => 'Kegiatan yang terlaksana wajib diisi',
            'keterangan.required' => 'Keterangan wajib diisi',
        ]);

        // Temukan entri progres berdasarkan ID
        $progres = entry_progres::find($id);

        if (!$progres) {
            return redirect()->route('uspeserta.progres')->with('error', 'Data progres tidak ditemukan');
        }

        // Update data progres
        $progres->tanggal = $request->tanggal;
        $progres->progres = $request->progres;
        $progres->keterangan = $request->keterangan;
        $progres->save();

        // Redirect ke halaman progres peserta dengan pesan sukses
        return redirect()->route('uspeserta.progres')->with('success', 'Data progres berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    // public function destroy(string $id)
    // {
    //     // Cari progres berdasarkan ID
    // $progres = entry_progres::findOrFail($id);
    
    // // Hapus progres
    // $progres->delete();

    // // Redirect ke halaman progres peserta dengan pesan sukses
    // return redirect()->route('uspeserta.progres')->with('success', 'Progres berhasil dihapus');
    // }

    public function destroy(string $no)
    {
        entry_progres::where('no',$no)->delete();
        //user::where('nomor_id',$nim)->delete();
        return redirect()->route('uspeserta.progres')->with('success', 'Berhasil menghapus data');
    }

    
}
