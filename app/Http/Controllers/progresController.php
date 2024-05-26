<?php

namespace App\Http\Controllers;

use App\Models\entry_progres;
use App\Models\nilai;
use App\Models\penyelia;
use App\Models\peserta;
use App\Models\aju_nilai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;


class progresController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        if ($user->role == 3) {
            $penyelia = penyelia::find($user->nomor_id);
    
            // Ambil daftar peserta yang terkait dengan penyelia
            $daftarPeserta = peserta::where('id_penyelia', $penyelia->id)->pluck('nim');
    
            // Menghitung jumlah progres yang sudah diverifikasi (status = Sudah)
            $jumlahProgresSudah = entry_progres::whereIn('nim_peserta', $daftarPeserta)
                ->where('status', 'Sudah')
                ->count();
    
            // Menghitung jumlah progres yang belum diverifikasi (status = Belum)
            $jumlahProgresBelum = entry_progres::whereIn('nim_peserta', $daftarPeserta)
                ->where('status', 'Belum')
                ->count();

            // $jumlahPesertaMengajukan  = entry_progres::whereIn('nim_peserta', $daftarPeserta)
            //     ->where('pengajuan', '0')
            //     ->count();

            // Simpan notifikasi jumlah progres belum diverifikasi ke dalam sesi
            session()->put('jumlahProgresBelum', $jumlahProgresBelum,);
        } else {
            $jumlahProgresSudah = 0;
            $jumlahProgresBelum = 0;
        }
        $peserta = Peserta::where('nim', auth()->user()->nomor_id)->first();
        $progres = entry_progres::where('nim_peserta', auth()->user()->nomor_id)
            ->get()
            ->sortByDesc('no');;
        $nilai = Nilai::where('nim_peserta', auth()->user()->nomor_id)->get();
        
        return view('uspeserta.progres', [
            'title' => 'Progres Peserta',
        ])->with(compact('peserta', 'progres', 'nilai'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // return view('uspeserta.createprogres');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // $validatedData = $request->validate([
        //     'tanggal' => 'required|date',
        //     'progres' => 'required|string',
        //     'keterangan' => 'nullable|string',
        // ]);

        // entry_progres::create([
        //     'nim_peserta' => Auth::user()->nomor_id,
        //     'tanggal' => $validatedData['tanggal'],
        //     'progres' => $validatedData['progres'],
        //     'keterangan' => $validatedData['keterangan'],
        // ]);

        // return redirect()->route('uspeserta.progres')->with('success', 'Progres berhasil ditambahkan.');
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
        aju_nilai::where('nim_peserta',$nim_peserta)->delete();
        //user::where('nomor_id',$nim)->delete();
        return redirect()->route('uspeserta.evaluasi')->with('success', 'Berhasil menghapus data');
    }

    public function ProgresPeserta($nim)
    {

        $peserta = peserta::where('nim', $nim)->first();
        $progres = entry_progres::where('nim_peserta', $nim)->get();
        $nilai = nilai::where('nim_peserta', $nim)->get();
        $penyelia = Penyelia::find($peserta->id_penyelia);

        $progres_belum = entry_progres::where('nim_peserta', $nim)
                    ->where('status', 'Belum')
                    ->orderByDesc('no')
                    ->get();

        $progres_sudah = entry_progres::where('nim_peserta', $nim)
                    ->where('status', 'Sudah')
                    ->orderByDesc('no')
                    ->get();

        $progres = $progres_belum->concat($progres_sudah);

        $pesertaList = Peserta::where('id_penyelia', $penyelia->id)
                        ->whereHas('aju_nilai', function ($query) {
                            $query->where('pengajuan', 0);
                        })
                        ->get();
        $ajukannilai = $pesertaList->count();
        
        return view('uspenyelia.progrespeserta', [
            'title' => 'Progres Peserta',
            'nim_peserta' => $nim,
            'penyelia' => $penyelia,
        ])->with(compact('peserta', 'progres', 'nilai', 'penyelia', 'pesertaList', 'ajukannilai'));

    }

    public function verifProgres($id_penyelia)
    {
        $user = Auth::user();
    if ($user->role == 3) {
        $penyelia = Penyelia::find($user->nomor_id);

        // Ambil daftar peserta yang terkait dengan penyelia
        $daftarPeserta = Peserta::where('id_penyelia', $penyelia->id)->pluck('nim');

        // Hitung jumlah progres yang belum diverifikasi (status = Belum)
        $jumlahProgresBelum = entry_progres::whereIn('nim_peserta', $daftarPeserta)
            ->where('status', 'Belum')
            ->count();
        session()->put('jumlahProgresBelum', $jumlahProgresBelum);
    } else {
        $jumlahProgresBelum = 0;
    }

    // Temukan data penyelia berdasarkan ID
    $penyelia = Penyelia::findOrFail($id_penyelia);

    // Ambil daftar progres yang belum diverifikasi oleh penyelia (status = Belum) dan urutkan secara descending berdasarkan nomor
    $progresBelum = entry_progres::whereHas('peserta', function($query) use ($id_penyelia) {
        $query->where('id_penyelia', $id_penyelia);
    })->where('status', 'Belum')->orderByDesc('no')->get();

    // Ambil daftar progres yang sudah diverifikasi oleh penyelia (status = Sudah) dan urutkan secara descending berdasarkan nomor
    $progresSudah = entry_progres::whereHas('peserta', function($query) use ($id_penyelia) {
        $query->where('id_penyelia', $id_penyelia);
    })->where('status', 'Sudah')->orderByDesc('no')->get();

    // Gabungkan progres yang belum diverifikasi di atas progres yang sudah diverifikasi
    $allProgres = $progresBelum->concat($progresSudah);

    $pesertaList = Peserta::where('id_penyelia', $penyelia->id)
                        ->whereHas('aju_nilai', function ($query) {
                            $query->where('pengajuan', 0);
                        })
                        ->get();
        $ajukannilai = $pesertaList->count();

    return view('uspenyelia.verifprogres', [
        'title' => 'Verifikasi Progres Peserta',
        'progresBelum' => $allProgres,
        'penyelia' => $penyelia,
    ])->with(compact('pesertaList', 'ajukannilai'));;

    //     $user = Auth::user();
    //     if ($user->role == 3) {
    //         $penyelia = penyelia::find($user->nomor_id);
    
    //         // Ambil daftar peserta yang terkait dengan penyelia
    //         $daftarPeserta = peserta::where('id_penyelia', $penyelia->id)->pluck('nim');
    
    //         // Menghitung jumlah progres yang sudah diverifikasi (status = Sudah)
    //         $jumlahProgresSudah = entry_progres::whereIn('nim_peserta', $daftarPeserta)
    //             ->where('status', 'Sudah')
    //             ->count();
    
    //         // Menghitung jumlah progres yang belum diverifikasi (status = Belum)
    //         $jumlahProgresBelum = entry_progres::whereIn('nim_peserta', $daftarPeserta)
    //             ->where('status', 'Belum')
    //             ->count();

    //         // Simpan notifikasi jumlah progres belum diverifikasi ke dalam sesi
    //         session()->put('jumlahProgresBelum', $jumlahProgresBelum);
    //     } else {
    //         $jumlahProgresSudah = 0;
    //         $jumlahProgresBelum = 0;
    //     }

    // // Temukan penyelia berdasarkan ID
    // $penyelia = Penyelia::findOrFail($id_penyelia);

    // // Ambil daftar progres yang belum diverifikasi oleh penyelia
    // $progresBelum = entry_progres::whereHas('peserta', function($query) use ($id_penyelia) {
    //     $query->where('id_penyelia', $id_penyelia);
    // })
    // ->get()
    // ->sortByDesc('no');
        

    // return view('uspenyelia.verifprogres', [
    //     'title' => 'Verifikasi Progres Peserta',
    //     'progresBelum' => $progresBelum,
    //     'penyelia' => $penyelia,
    // ]);
    }

    public function updateStatus(Request $request, $id_penyelia)
{
    // Validasi input atau handle jika nomor tidak ditemukan
    $request->validate([
        'no' => 'required|exists:entry_progres,no', // Pastikan id progres valid
        'status' => 'required|in:Belum,Sudah', // Menentukan status yang valid
    ]);

    // Cari entry progres berdasarkan nomor
    $progres = entry_progres::where('no', $request->no)->first();

    // Periksa apakah entri progres ditemukan
    if (!$progres) {
        return redirect()->back()->with('error', 'Entri progres tidak ditemukan.');
    }

    // Lakukan perubahan status
    $progres->status = 'Sudah'; // Ambil status dari input form
    $progres->save();

    // Redirect atau lakukan tindakan lainnya setelah berhasil menyimpan
    return redirect()->back()->with('success', 'Status progres berhasil diperbarui.');
}

public function batalVerifikasi(Request $request, $id_penyelia)
{
    // Validasi input atau handle jika nomor tidak ditemukan
    $request->validate([
        'no' => 'required|exists:entry_progres,no', // Pastikan id progres valid
        'status' => 'required|in:Belum,Sudah', // Menentukan status yang valid
    ]);

    // Dapatkan ID progres dari request
    $no_progres = $request->input('no');

    // Cari entry progres berdasarkan nomor
    $progres = entry_progres::where('no', $no_progres)->first();

    // Periksa apakah entri progres ditemukan
    if (!$progres) {
        return redirect()->back()->with('error', 'Entri progres tidak ditemukan.');
    }

    // Lakukan perubahan status menjadi "Belum"
    $progres->status = 'Belum';
    $progres->save();

    // Redirect atau lakukan tindakan lainnya setelah berhasil menyimpan
    return redirect()->back()->with('cancel', 'Verifikasi progres berhasil dibatalkan.');
    // return redirect()->route('uspenyelia.verifprogres', $id_penyelia)->with('cancel', 'Verifikasi progres berhasil dibatalkan.');
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




    // public function createProgres()
    // {
    //     $id_penyelia = request()->input('id_penyelia'); // Dapatkan nilai nim_peserta dari request jika tersedia
    //     return view('uspeserta.createprogres', compact('id_penyelia'));
    // }

    // public function storeProgres(Request $request)
    // {
    //     $request->validate([
    //         'tanggal' => 'required',
    //         'progres' => 'required',
    //         'keterangan' => 'required',
    //     ], [
    //         'tanggal.required' => 'Tanggal wajib diisi',
    //         'progres.required' => 'Kegiatan yang terlaksana wajib diisi',
    //         'keterangan.required' => 'Keterangan wajib diisi',
    //     ]);
    
    //     // Dapatkan ID penyelia yang login
    //     $nim_peserta = auth()->user()->nomor_id;
    
    //     // Dapatkan ID penyelia yang terkait dengan nim_peserta
    //     $id_penyelia = Peserta::where('nim', $nim_peserta)->value('id_penyelia');
    
    //     // Pastikan nama kolom pada model Nilai sesuai dengan kolom pada tabel di database
    //     entry_progres::create([
    //         'tanggal' => $request->tanggal,
    //         'progres' => $request->progres,
    //         'keterangan' => $request->keterangan,
    //         'nim_peserta' => $nim_peserta,
    //         'id_penyelia' => $id_penyelia,
    //     ]);
    
    //     // Redirect ke halaman progres peserta
    //     return redirect()->route('uspeserta.progres')->with('success', 'Berhasil menambahkan data');
    // }

    // public function createNilai()
    // {
    //     $nim_peserta = auth()->user()->nim;
    //     $id_penyelia = auth()->user()->nomor_id;
    //     return view('uspenyelia.createnilai', compact('nim_peserta', 'id_penyelia'));
    // }

    // public function storeNilai(Request $request)
    // {
    //     // Validasi data yang diterima dari form
    // $validatedData = $request->validate([
    //     'nilai' => 'required|numeric|min:0|max:100',
    //     'evaluasi' => 'required|string|max:500',
    //     // Anda mungkin perlu menambahkan validasi tambahan sesuai kebutuhan
    // ]);

    //     // Simpan data ke dalam tabel nilai
    //     $nilai = new Nilai;
    //     $nilai->nim_peserta = $request->nim_peserta;
    //     $nilai->nilai = $request->nilai;
    //     $nilai->evaluasi = $request->evaluasi;
    //     $nilai->id_penyelia = auth()->user()->nomor_id; // Menggunakan ID penyelia yang sedang login
    //     $nilai->save();

    //     // Redirect atau tampilkan pesan sukses, dll.
    //     return Redirect::route('uspenyelia.progrespeserta', ['nim' => $request->nim_peserta])->with('success', 'Data nilai berhasil disimpan.');
    // }
}
