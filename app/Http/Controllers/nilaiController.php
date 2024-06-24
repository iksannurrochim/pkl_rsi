<?php

namespace App\Http\Controllers;

use App\Models\nilai;
use App\Models\peserta;
use App\Models\penyelia;
use App\Models\aju_nilai;
use App\Models\nilep;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

class nilaiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $peserta = Peserta::where('nim', Auth::user()->nomor_id)->first();
        $nim_peserta = auth()->user()->nomor_id;
        $nilai = nilai::where('nim_peserta', $nim_peserta)->first();

        $aju_nilai = aju_nilai::where('nim_peserta', $nim_peserta)->first();
        return view('uspeserta.evaluasi', ['aju_nilai' => $aju_nilai, 'nilai' => $nilai, 'peserta' => $peserta]);
    }

    /**
     * Show the form for creating a new resource.
     */
     public function create()
    {
    //     $user = Auth::user();
    //     $penyelia = Penyelia::where('id', $user->nomor_id)->first();

    //     return view('nilai.create', compact('penyelia'));
    // $peserta = peserta::where('nim', $nim)->first();
    // $nilai = nilai::where('nim_peserta', $nim)->get();

    // // Validasi apakah peserta ditemukan dan apakah terkait dengan penyelia yang sedang login
    // if (!$peserta || $peserta->penyelia_id !== Auth::user()->nomor_id) {
    //     return redirect()->back()->with('error', 'Peserta tidak ditemukan atau tidak terkait dengan Anda.');
    //     }
    // // $nim_peserta = request()->input('nim_peserta'); 
    // $penyelia = Penyelia::find(Auth::user()->nomor_id);
    // //return view('nilai.create', compact('nilai', 'peserta', 'penyelia'));
    // return view('nilai.create', [
    //     'title' => 'Nilai Peserta',
    //     'nim_peserta' => $nim,
    //     'penyelia' => $penyelia,
    // ])->with(compact('peserta', 'nilai', 'penyelia'));
    }

    /**
     * Store a newly created resource in storage.
     */
    
    public function store(Request $request)
    {
        $request->validate([
            'nilai' => 'required|numeric',
            'evaluasi' => 'required',
        ], [
            'nilai.required' => 'Nilai wajib diisi',
            'evaluasi.required' => 'Evaluasi wajib diisi',
        ]);
    
        // Dapatkan ID penyelia yang login
        $idPenyelia = auth()->user()->nomor_id;
        $user = Auth::user();
        $penyelia = Penyelia::where('id', $user->nomor_id)->first();
    
        // Cari data peserta berdasarkan nim
        $nimPeserta = $request->nim_peserta;
        $peserta = Peserta::where('nim', $nimPeserta)->first();
    
        if (!$peserta) {
            return response()->json(['error' => 'Peserta tidak ditemukan'], 404);
        }
    
        $nilai = Nilep::create([
            'nim_peserta' => $nimPeserta,
            'nilai' => $request->nilai,
            'evaluasi' => $request->evaluasi,
            'id_penyelia' => $idPenyelia,
        ]);
    
        if ($nilai) {
            aju_nilai::where('nim_peserta', $nimPeserta)
                ->update(['pengajuan' => 1]);
            return response()->json(['success' => 'Berhasil menambahkan data']);
        }
    
        return response()->json(['error' => 'Gagal menambahkan data'], 500);
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
    public function destroy(string $nim_peserta)
    {
        nilai::where('nim_peserta',$nim_peserta)->delete();
        return redirect()->route('uspenyelia.progrespeserta', $nim_peserta)->with('success', 'Berhasil menghapus data');
    }


    public function notifNilai($id_penyelia)
    {
        $user = Auth::user();
        $penyelia = Penyelia::where('id', $user->nomor_id)->first();
        $peserta = peserta::where('nim', Auth::user()->nomor_id)->first();
    
        // Hitung jumlah peserta yang memiliki nilai pengajuan 0
        $jumlahPesertaMengajukan = $penyelia->peserta()->whereHas('nilai', function ($query) {
            $query->where('pengajuan', 0);
        })->count();
    
        return view('uspenyelia.pengajuannilai', compact('peserta', 'penyelia', 'jumlahPesertaMengajukan'));
    }

    public function ajukanNilai(Request $request)
    {
        $nim_peserta = auth()->user()->nomor_id;
        $peserta = Peserta::where('nim', $nim_peserta)->first();

        if (!$peserta) {
            return redirect()->back()->with('error', 'Peserta tidak ditemukan');
        }

        // $aju_nilai = aju_nilai::where('nim_peserta', $nim_peserta)->where('pengajuan', 0)->first();

        // if ($aju_nilai) {
        //     // Jika sudah ada, update pengajuan menjadi 0
        //     $aju_nilai->update(['pengajuan' => 0, 'id_penyelia' => $peserta->id_penyelia]);
        // } else {
        //     // Jika belum ada, buat entri baru
        //     $aju_nilai = aju_nilai::create([
        //         'nim_peserta' => $nim_peserta,
        //         'pengajuan' => 0,
        //         'id_penyelia' => $peserta->id_penyelia,
        //     ]);
        // }

            // Temukan atau buat entri baru dalam tabel aju_nilai
    $aju_nilai = aju_nilai::firstOrNew(['nim_peserta' => $nim_peserta]);

    if (!$aju_nilai->exists) {
        // Jika entri baru, atur nilainya
        $aju_nilai->pengajuan = 0;
        $aju_nilai->id_penyelia = $peserta->id_penyelia;
        $aju_nilai->save();
    }

        return redirect()->route('uspeserta.evaluasi')->with('aju_nilai', $aju_nilai)->with('success', 'Nilai berhasil diajukan');
    
        // $nim_peserta = auth()->user()->nomor_id;
        // $peserta = peserta::where('nim', $nim_peserta)->first();
        // if (!$peserta) {
        //     return redirect()->back()->with('error', 'Peserta tidak ditemukan');
        // }

        // $nilai = nilai::where('nim_peserta', $nim_peserta)->first();

        // if ($nilai) {
        //     $nilai->update(['pengajuan' => 0, 'id_penyelia' => $peserta->id_penyelia]);
        // } else {
        //     nilai::create([
        //         'nim_peserta' => $nim_peserta,
        //         'pengajuan' => 0,
        //         'id_penyelia' => $peserta->id_penyelia,
        //     ]);
        // }
        // return redirect()->route('uspeserta.evaluasi')->with('success', 'Nilai berhasil diajukan');
    }

    // public function showNilai($nim)
    // {
    // $peserta = peserta::where('nim', $nim)->first();
    // $nilai = nilai::where('nim_peserta', $nim)->get();

    // // Validasi apakah peserta ditemukan dan apakah terkait dengan penyelia yang sedang login
    // if (!$peserta || $peserta->penyelia_id !== Auth::user()->nomor_id) {
    //     return redirect()->back()->with('error', 'Peserta tidak ditemukan atau tidak terkait dengan Anda.');
    //     }
    // // $nim_peserta = request()->input('nim_peserta'); 
    // $penyelia = Penyelia::find(Auth::user()->nomor_id);
    // //return view('nilai.create', compact('nilai', 'peserta', 'penyelia'));
    // return view('nilai.create', [
    //     'title' => 'Nilai Peserta',
    //     'nim_peserta' => $nim,
    //     'penyelia' => $penyelia,
    // ])->with(compact('peserta', 'nilai', 'penyelia'));
    // }


    
    public function setujuiNilai($id_penyelia)
    {
        $user = Auth::user();
        $penyelia = Penyelia::where('id', $user->nomor_id)->first();

        if (!$penyelia) {
            return redirect()->back()->with('error', 'Penyelia tidak ditemukan');
        }

        // Ambil daftar peserta yang terkait dengan penyelia dan memiliki pengajuan 0 atau 1
        $pesertaList = Peserta::where('id_penyelia', $penyelia->id)
                        ->whereHas('aju_nilai', function ($query) {
                            $query->whereIn('pengajuan', [0, 1]);
                        })
                        ->with('aju_nilai') // Pastikan untuk memuat relasi
                        ->get();

        // Mengurutkan peserta berdasarkan status pengajuan
        $pesertaList = $pesertaList->sortBy(function($peserta) {
            return $peserta->aju_nilai->first()->pengajuan;
        });

        return view('uspenyelia.pengajuannilai', compact('penyelia', 'pesertaList'));
    }

    public function showNilai($nim)
    {
        $user = Auth::user();
        // $penyelia = Penyelia::where('id', $user->nomor_id)->first();
        $peserta = peserta::where('nim', $nim)->first();
        $nilai = nilai::where('nim_peserta', $nim)->get();
        $penyelia = Penyelia::find($peserta->id_penyelia);

        $pesertaList = Peserta::where('id_penyelia', $penyelia->id)
                        ->whereHas('aju_nilai', function ($query) {
                            $query->where('pengajuan', 0);
                        })
                        ->get();
        $ajukannilai = $pesertaList->count();

        return view('nilai.shownilai', [
            'title' => 'Progres Peserta',
            'nim_peserta' => $nim,
            'penyelia' => $penyelia,
        ])->with(compact('peserta', 'nilai', 'penyelia', 'pesertaList', 'ajukannilai'));
    // $peserta = peserta::where('nim', $nim)->first();
    // $nilai = nilai::where('nim_peserta', $nim)->get();

    // // Validasi apakah peserta ditemukan dan apakah terkait dengan penyelia yang sedang login
    // if (!$peserta || $peserta->penyelia_id !== Auth::user()->nomor_id) {
    //     return redirect()->back()->with('error', 'Peserta tidak ditemukan atau tidak terkait dengan Anda.');
    //     }
    // // $nim_peserta = request()->input('nim_peserta'); 
    // $penyelia = Penyelia::find(Auth::user()->nomor_id);
    // //return view('nilai.create', compact('nilai', 'peserta', 'penyelia'));
    // return view('nilai.create', [
    //     'title' => 'Nilai Peserta',
    //     'nim_peserta' => $nim,
    //     'penyelia' => $penyelia,
    // ])->with(compact('peserta', 'nilai', 'penyelia'));
    }

    public function nilaiPeserta()
    {
        $peserta = Peserta::where('nim', Auth::user()->nomor_id)->first();
        // Dapatkan nomor ID peserta yang login
        $nim_peserta = Auth::user()->nomor_id;

        // Ambil data nilai dari tabel 'nilep' berdasarkan nim peserta
        $nilai = Nilep::where('nim_peserta', $nim_peserta)->get();

        // Kirim data ke view

        return view('nilai.nilaipeserta', [
            'title' => 'Edit Profile'
        ])->with(compact('nilai', 'peserta'));
    }

    public function batalAjukanNilai(Request $request)
    {
        $nim_peserta = auth()->user()->nomor_id;
        
        // Hapus data peserta yang mengajukan dari semua kolom di tabel aju_nilai
        aju_nilai::where('nim_peserta', $nim_peserta)->delete();

        return redirect()->back()->with('cancel', 'Ajukan Nilai berhasil dibatalkan.');
    }


    public function lihatNilai($nim_peserta)
    {
        // Ambil user yang sedang login
        $user = Auth::user();

        // Temukan penyelia berdasarkan nomor_id user
        $penyelia = Penyelia::where('id', $user->nomor_id)->first();

        if (!$penyelia) {
            return redirect()->back()->with('error', 'Penyelia tidak ditemukan');
        }

        // Temukan peserta yang sesuai dengan nim_peserta dan penyelia yang login
        $peserta = Peserta::where('nim', $nim_peserta)
                        ->where('id_penyelia', $penyelia->id)
                        ->first();

        if (!$peserta) {
            return redirect()->back()->with('error', 'Peserta tidak ditemukan atau tidak terkait dengan penyelia yang login');
        }

        // Ambil nilai yang terkait dengan peserta
        $nilai = Nilep::where('nim_peserta', $peserta->nim)->get();

        // Tampilkan view dengan nilai peserta
        return view('uspenyelia.lihatnilai', compact('peserta', 'nilai', 'penyelia'));
            
    }

    public function editNilai($nim_peserta)
    {
        $penyelia = Auth::user();
    
        // Pastikan nim peserta valid dan terkait dengan penyelia yang sedang login
        $nilai = Nilep::where('nim_peserta', $nim_peserta)
                    ->where('id_penyelia', $penyelia->nomor_id)
                    ->firstOrFail();

        // Ambil data peserta berdasarkan nim peserta yang nilainya sedang diedit
        $peserta = Peserta::where('nim', $nim_peserta)->first();

        // Pastikan peserta ditemukan
        if (!$peserta) {
            return redirect()->route('dashboard')->withErrors('Peserta tidak ditemukan.');
        }

        return view('nilai.edit', compact('nilai', 'penyelia', 'peserta'));
    }


    public function updateNilai(Request $request, $nim_peserta)
    {
        $request->validate([
            'nilai' => 'required|numeric',
            'evaluasi' => 'required|string',
        ]);
    
        $peserta = Peserta::where('nim', $nim_peserta)->first();
        $penyelia = Auth::user();
    
        $nilai = Nilep::where('nim_peserta', $nim_peserta)
                      ->where('id_penyelia', $penyelia->nomor_id)
                      ->firstOrFail();
    
        $nilai->nilai = $request->input('nilai');
        $nilai->evaluasi = $request->input('evaluasi');
        $nilai->save();
    
        return redirect()->route('uspenyelia.lihatnilai', $peserta->nim)->with('success', 'Nilai berhasil diperbarui');
    }

    public function destroyNilai($nim_peserta)
    {
        try {
            // Hapus data dari tabel nilep
            Nilep::where('nim_peserta', $nim_peserta)->delete();

            // Update nilai pengajuan di tabel aju_nilai menjadi 0
            aju_nilai::where('nim_peserta', $nim_peserta)->update(['pengajuan' => 0]);

            // Redirect dengan pesan sukses
            $penyelia = Auth::user();
            return redirect()->route('uspenyelia.pengajuannilai', $penyelia->nomor_id)->with('success', 'Nilai berhasil dihapus');
        } catch (\Exception $e) {
            // Redirect dengan pesan error
            $penyelia = Auth::user();
            return redirect()->route('uspenyelia.pengajuannilai', $penyelia->nomor_id)->with('error', 'Terjadi kesalahan saat menghapus nilai');
        }
        
    }


}

