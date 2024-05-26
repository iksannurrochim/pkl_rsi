<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\penyelia;
use App\Models\Materi;
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

class MateriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $materis = Materi::all();
        $penyelia = Penyelia::where('id', Auth::user()->nomor_id)->first();
        return view('materi.index', [
            'title' => 'Materi'
        ])->with(compact('penyelia', 'materis'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $materis = Materi::all();
        $penyelia = Penyelia::where('id', Auth::user()->nomor_id)->first();
        return view('materi.create', [
            'title' => 'Materi'
        ])->with(compact('penyelia', 'materis'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'nama_file' => 'required|string|max:255',
            'file' => 'required|mimes:pdf|max:2048',
        ]);

        // Ambil file dari request
        $file = $request->file('file');
        $fileName = $file->getClientOriginalName();
        
        // Tentukan jalur penyimpanan file
        $filePath = 'files/materi/' . $fileName;
        
        // Pindahkan file ke folder public/files/materi
        $file->move(public_path('files/materi'), $fileName);

        // Simpan data ke database
        Materi::create([
            'nama_file' => $request->nama_file,
            'file' => $filePath,
            'id_penyelia' => auth()->user()->nomor_id,
        ]);

        // Redirect dengan pesan sukses
        return redirect()->route('materi.index')->with('success', 'Materi berhasil ditambahkan');
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
        $materi = Materi::findOrFail($id);
        $penyelia = Penyelia::where('id', Auth::user()->nomor_id)->first();
        return view('materi.edit', compact('materi', 'penyelia'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $materi = Materi::findOrFail($id);

        $request->validate([
            'nama_file' => 'required|string|max:255',
            'file' => 'nullable|mimes:pdf|max:2048',
        ]);

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = time().'_'.$file->getClientOriginalName();
            $filePath = $file->storeAs('uploads', $fileName, 'public');

            // Delete old file if exists
            if ($materi->file && Storage::exists('public/'.str_replace('files/materi', '', $materi->file))) {
                Storage::delete('public/'.str_replace('files/materi', '', $materi->file));
            }

            $materi->file = 'files/materi' . $filePath;
        }

        $materi->nama_file = $request->nama_file;
        $materi->save();

        return redirect()->route('materi.index')->with('success', 'Materi berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $materi = Materi::findOrFail($id);
        $materi->delete();

        return redirect()->route('materi.index')->with('success', 'Materi berhasil dihapus');
    }
}
