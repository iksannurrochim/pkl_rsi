<?php

namespace App\Http\Controllers;

use App\Models\aju_nilai;
use App\Models\User;
use App\Models\penyelia;
use App\Models\instansi;
use App\Models\materi;
use App\Models\nilai;
use App\Models\peserta;
use App\Models\entry_progres;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function showDashboard(Request $request)
    {
        // Dapatkan data instansi
        $instansi = Instansi::pluck('nama', 'id');

        $katakunci = $request->katakunci;
        $jumlahbaris = $request->session()->get('jumlahbaris', 20);

        // Modifikasi query pencarian
        if (strlen($katakunci)) {
            $data = Peserta::whereHas('instansi', function ($query) use ($katakunci) {
                $query->where('nama', 'like', "%$katakunci%");
            })->orWhere('nama', 'like', "%$katakunci%")
            ->orWhere('nim', 'like', "%$katakunci%")
            ->paginate($jumlahbaris);
        } else {
            $data = Peserta::orderBy('instansi_id', 'asc')->paginate($jumlahbaris);
        }

        // Kirim data instansi ke view
        $managers = $instansi->all();

        return view('list_home', compact('data', 'managers'));

    }

    // public function showDashboardAdmin()
    // {
    //     return view('dashboardadmin');
    // }

    public function index()
    {
        $user = Auth::user();
        $users = User::where('nomor_id', Auth::user()->nomor_id)->first();
        $peserta = peserta::where('nim', Auth::user()->nomor_id)->first();
        $data = Peserta::join('instansi', 'peserta.instansi_id', '=', 'instansi.id')
            ->select('instansi.nama as instansi', DB::raw('COUNT(*) as jumlah_peserta'))
            ->groupBy('instansi.nama') // Ubah ke 'instansi.nama' sesuai kolom yang di-group
            ->get();

        $labels = $data->pluck('instansi')->toArray();
        $values = $data->pluck('jumlah_peserta')->toArray();

        $penyelia = penyelia::where('id', Auth::user()->nomor_id)->first();

        if ($penyelia) {
            $jumlahPesertaPenyelia = peserta::where('id_penyelia', $penyelia->id)->count();
            $pesertaList = Peserta::where('id_penyelia', $penyelia->id)
                            ->whereHas('aju_nilai', function ($query) {
                                $query->where('pengajuan', 0);
                            })
                            ->get();
        $ajukannilai = $pesertaList->count();
        } else {
            $jumlahPesertaPenyelia = 0;
        }
        // $jumlahPesertaPenyelia = peserta::where('id_penyelia', $penyelia->id)->count();

        
        $jumlahPeserta = peserta::count();
        $jumlahInstansi = instansi::count();
        $jumlahPenyelia = penyelia::count();
        $jumlahMateri = materi::count();

        // $pesertaList = Peserta::where('id_penyelia', $penyelia->id)
        //                 ->whereHas('aju_nilai', function ($query) {
        //                     $query->where('pengajuan', 0);
        //                 })
        //                 ->get();
        // $ajukannilai = $pesertaList->count();

        // $jumlahPesertaMengajukan = $penyelia->pesertas()->whereHas('nilai', function ($query) {
        //     $query->where('pengajuan', 0);
        // })->count();

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

            $jumlahPesertaMengajukan  = $penyelia->pesertas()->whereHas('nilai', function ($query) {
                $query->where('pengajuan', 0);
                })->count();

            // Simpan notifikasi jumlah progres belum diverifikasi ke dalam sesi
            session()->put('jumlahProgresBelum', $jumlahProgresBelum);
            session()->put('jumlahPesertaMengajukan', $jumlahPesertaMengajukan);
        } else {
            $jumlahProgresSudah = 0;
            $jumlahProgresBelum = 0;
            $jumlahPesertaMengajukan = 0;
        }

        switch ($user->role) {
            case 1:
                // Logika untuk peserta
                return view('uspeserta.dashboardpeserta', [
                    'title' => 'Dashboard Peserta',
                ])->with(compact('peserta', 'jumlahPeserta', 'penyelia', 'jumlahPenyelia', 'jumlahInstansi' ));
                break;

            case 2:
                // Logika untuk operator
                return view('peserta.profiladmin', [
                    'title' => 'Dashboard Operator',
                    'labels' => $labels,
                    'values' => $values,
                    'jumlahPeserta' => Peserta::count(),
                    'jumlahPenyelia' => Penyelia::count(),
                    'jumlahInstansi' => Instansi::count(),
                ])->with(compact('peserta', 'users', 'jumlahPeserta', 'penyelia', 'jumlahPenyelia', 'jumlahInstansi', 'labels', 'values'));
                break;
                
            case 3:
                // Logika untuk pengelola
                return view('uspenyelia.profilpenyelia', [
                    'title' => 'Dashboard Penyelia',
                ])->with(compact('peserta', 'jumlahPeserta', 'penyelia', 'jumlahPenyelia', 'jumlahInstansi', 'jumlahPesertaPenyelia', 'jumlahProgresSudah', 'jumlahProgresBelum', 'ajukannilai', 'jumlahMateri'));
                break;
        }
    }
    // public function profilAdmin()
    // {
    //     return view('peserta.profiladmin');
    // }

    // public function profilPenyelia()
    // {
    //     return view('uspenyelia.profilpenyelia');
    // }

    public function profilPeserta()
    {
        return view('uspenyelia.profilpeserta');
    }

    public function listPeserta()
    {
        return view('uspenyelia.listpeserta');
    }

    // public function dashboardPeserta()
    // {
    //     return view('uspeserta.dashboardpeserta');
    // }

    public function jumlahPeserta()
    {
        $jumlahPeserta = peserta::count();
        $jumlahInstansi = instansi::count();
        $jumlahPenyelia = penyelia::count();
        return view('peserta.profiladmin', compact('jumlahPeserta', 'jumlahInstansi', 'jumlahPenyelia'));
    }

    public function daftarMahasiswaPenyelia($id_penyelia)
    {
        $user = Auth::user();
        $penyelia = Penyelia::where('id', $user->nomor_id)->first();
        $peserta = Peserta::where('id_penyelia', $penyelia->id)->paginate(20);
    
        $instansiManagers = Instansi::pluck('nama', 'id');
    
        // Ambil data status dari tabel aju_nilai
        $statusSelesai = aju_nilai::whereIn('nim_peserta', $peserta->pluck('nim')->toArray())->where('pengajuan', 1)->pluck('pengajuan', 'nim_peserta');
    
        return view('uspenyelia.index', compact('peserta', 'instansiManagers', 'penyelia', 'statusSelesai'));

    }

    public function dashboardPenyelia()
    {
        $jumlahProgresSudah = entry_progres::where('status', 'Sudah')->count();

        $jumlahProgresBelum = entry_progres::where('status', 'Belum')->count();

        return view('uspenyelia.profilpenyelia', compact('jumlahProgresSudah', 'jumlahProgresBelum'));
    }

    public function notifNilai($id_penyelia)
{
    $user = Auth::user();
    $penyelia = Penyelia::where('id', $user->nomor_id)->first();
    $peserta = peserta::where('nim', Auth::user()->nomor_id)->first();

    // Hitung jumlah peserta yang memiliki nilai pengajuan 0
    $jumlahPesertaMengajukan = $penyelia->peserta()->whereHas('aju_nilai', function ($query) {
        $query->where('pengajuan', 0);
    })->count();

    return view('uspenyelia.pengajuannilai', compact('peserta', 'penyelia', 'jumlahPesertaMengajukan'));
}
    
    
}
