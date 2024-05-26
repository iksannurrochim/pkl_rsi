<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\nilai;
use App\Models\peserta;
use App\Models\penyelia;
use App\Models\aju_nilai;
use App\Models\nilep;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

class NilepController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = Auth::user();

        // Ambil peserta berdasarkan nomor_id pengguna yang sedang login
        $peserta = Peserta::where('nim', $user->nomor_id)->first();
    
        // Pastikan peserta ditemukan
        if (!$peserta) {
            // Tangani kasus di mana peserta tidak ditemukan, misalnya dengan mengarahkan kembali atau menampilkan pesan error
            return redirect()->back()->with('error', 'Peserta tidak ditemukan.');
        }
    
        // Ambil nilai berdasarkan nim peserta
        $nilai = nilep::where('nim_peserta', $peserta->nim)->get();
    
        // Ambil penyelia berdasarkan id_penyelia dari peserta
        $penyelia = Penyelia::find($peserta->id_penyelia);
    
        // Ambil daftar peserta yang belum mengajukan nilai
        $pesertaList = Peserta::where('id_penyelia', $penyelia->id)
                        ->whereHas('aju_nilai', function ($query) {
                            $query->where('pengajuan', 0);
                        })
                        ->get();
        $ajukannilai = $pesertaList->count();
    
        return view('nilep.create', [
            'title' => 'Progres Peserta',
            'nim_peserta' => $peserta->nim,
            'penyelia' => $penyelia,
        ])->with(compact('peserta', 'nilai', 'penyelia', 'pesertaList', 'ajukannilai'));
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
