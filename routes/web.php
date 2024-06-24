<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\progresController;
use App\Http\Controllers\progesPesertaController;
use App\Http\Controllers\UbahPasswordAdminController;
use App\Http\Controllers\UbahPasswordPenyController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PesertaController;
use App\Http\Controllers\instansiController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardAdmin;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EditProfilController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\listPeserta;
use App\Http\Controllers\MateriController;
use App\Http\Controllers\MateriPesertaController;
use App\Http\Controllers\nilaiController;
use App\Http\Controllers\NilepController;
use App\Http\Controllers\opController;
use App\Http\Controllers\OperatorEditController;
use App\Http\Controllers\penyeliaController;
use App\Http\Controllers\PenyeliaEditController;
use App\Http\Controllers\PesertaEditController;
use App\Http\Controllers\SesiController;
use App\Http\Controllers\UbahPasswordController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('home', function(){
//     return view('main');
// });

// Route::get('/', [PesertaController::class, 'index']);

Route::get('/', [HomeController::class, 'showHome']);
Route::get('/list_home', [DashboardController::class, 'showDashboard'])->name('list_home')->withoutMiddleware(['auth']);;

Route::group(['middleware' => ['prevent-back-history']], function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->middleware('guest');
    Route::post('/login', [AuthController::class, 'authenticate'])->middleware('guest')->name('login');
    Route::get('/logout', [AuthController::class, 'logout'])->middleware('auth');
    Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');
});

Route::group(['middleware' => ['auth','prevent-back-history']], function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/uspenyelia/{id_penyelia}/index', [DashboardController::class, 'daftarMahasiswaPenyelia'])->name('uspenyelia.index');
   //Route::resource('/uspeserta/progres', progresController::class);
    Route::get('/uspeserta/progres', [progresController::class, 'index'])->name('uspeserta.progres');
    // Route::get('/uspenyelia/progrespeserta', [progresController::class, 'ProgresPeserta'])->name('uspenyelia.progrespeserta');
    Route::get('/uspenyelia/createprogres', [progresController::class, 'createProgres'])->name('uspenyelia.createprogres');
    Route::get('/uspenyelia/createnilai', [progresController::class, 'createNilai'])->name('uspenyelia.createnilai');
    // Route::post('/uspenyelia/createnilai', [progresController::class, 'storeNilai'])->name('uspenyelia.createnilai');
    // Route::get('/nilai/create', [nilaiController::class, 'create'])->name('nilai.create');
    // Route::post('/nilai/create', [nilaiController::class, 'create'])->name('nilai.create');
    Route::get('/nilai/{nim}/shownilai', [nilaiController::class, 'showNilai'])->name('nilai.shownilai');
    Route::post('/nilai/store', [nilaiController::class, 'store'])->name('nilai.store');
    Route::get('/nilai/{nim}/nilaipeserta', [NilaiController::class, 'nilaiPeserta'])->name('nilai.nilaipeserta');
    Route::get('/uspenyelia/{nim}/lihatnilai', [NilaiController::class, 'lihatNilai'])->name('uspenyelia.lihatnilai');

    Route::get('/progres/create', [progesPesertaController::class, 'create'])->name('progres.create');
    
    //Route::delete('/progres/{id}', [progesPesertaController::class, 'destroy'])->name('uspeserta.progres.destroy');
    route::delete('/uspeserta/{no}', [progesPesertaController::class, 'destroy'])->name('uspeserta.destroy');
    route::delete('/uspenyelia/{nim_peserta}/progrespeserta', [nilaiController::class, 'destroy'])->name('uspenyelia.destroy');
    Route::get('/uspenyelia/{id_penyelia}/verifprogres', [progresController::class, 'verifProgres'])->name('uspenyelia.verifprogres');
    Route::put('/uspenyelia/{id_penyelia}/verifprogres', [progresController::class, 'updateStatus'])->name('uspenyelia.verifprogres');
    Route::put('/uspenyelia/{id_penyelia}/batalverifikasi', [progresController::class, 'batalVerifikasi'])->name('uspenyelia.batalVerifikasi');
    Route::get('/uspeserta/{no}/editprogres', [progesPesertaController::class, 'edit'])->name('uspeserta.editprogres');
    Route::put('/uspeserta/{no}/editprogres', [progesPesertaController::class, 'update'])->name('uspeserta.editprogres');
    Route::get('/uspeserta/evaluasi', [nilaiController::class, 'index'])->name('uspeserta.evaluasi');
    Route::post('/uspeserta/evaluasi', [nilaiController::class, 'ajukanNilai'])->name('uspeserta.evaluasi');
    Route::delete('/uspeserta/batal-ajukan/{nim_peserta}', [ProgresController::class, 'destroy'])->name('uspeserta.batal-ajukan');
    Route::get('/nilai/{nim_peserta}/edit', [nilaiController::class, 'editNilai'])->name('nilai.edit');
    Route::put('/nilai/{nim_peserta}', [nilaiController::class, 'updateNilai'])->name('nilai.update');
    Route::delete('/nilai/destroyNilai/{nim_peserta}', [nilaiController::class, 'destroyNilai'])->name('nilai.destroyNilai');

    Route::get('/uspenyelia/{id_penyelia}/pengajuannilai', [nilaiController::class, 'setujuiNilai'])->name('uspenyelia.pengajuannilai');
    // Route::post('/nilai/{nim}/storenilai', [nilaiController::class, 'store'])->name('nilai.shownilai');

    // Route::get('/uspeserta/{nim}/editprofil', [PesertaEditController::class, 'index'])->name('uspeserta.editprofil');
    // Route::put('/uspeserta/{nim}/editprofil', [PesertaEditController::class, 'update'])->name('uspeserta.updateprofil');

    //Route::resource('/uspeserta/editprofil', PesertaEditController::class)->names('edit_profil_peserta');
    // Route::get('/uspeserta/createprogres', [ProgresController::class, 'createProgres'])->name('uspeserta.createprogres');
    //Route::resource('/peserta/editprofile', PesertaEditController::class)->names('edit_profile_peserta');
    // Route::resource('uspeserta', PesertaEditController::class);
    Route::resource('/peserta/edit_profil', PesertaEditController::class);
    Route::resource('/penyelia/edit_profil_penyelia', PenyeliaEditController::class);
    Route::resource('/operator/edit_profil_operator', OperatorEditController::class);
    Route::resource('/peserta/ubah_password', UbahPasswordController::class);
    Route::resource('/penyelia/ubah_password_penyelia', UbahPasswordPenyController::class);
    // Route::resource('/operator/ubah_password_operator', UbahPasswordAdminController::class);
    Route::get('/ubahpass_admin/{nomor_id}/index', [UbahPasswordAdminController::class, 'index'])->name('ubahpass_admin.index');
    Route::put('/ubahpass_admin/{nomor_id}/update', [UbahPasswordAdminController::class, 'update'])->name('ubahpass_admin.update');
    // Route::put('/operator/ubah_password_operator', [UbahPasswordAdminController::class, 'update'])->name('ubahpass_admin.index');
    Route::resource('materi', MateriController::class);
    Route::resource('materipeserta', MateriPesertaController::class);
    Route::resource('/penyelia/nilep', NilepController::class);
    // Route::get('/materipeserta/download/{id}', [MateriPesertaController::class, 'download'])->name('materipeserta.download');

    Route::resource('nilai', nilaiController::class);
    Route::resource('progres', progesPesertaController::class);

    Route::get('/uspenyelia/{nim}/progrespeserta', [progresController::class, 'ProgresPeserta'])->name('uspenyelia.progrespeserta');

    Route::group(['middleware' => ['operator']], function (){
        Route::resource('peserta', PesertaController::class);
        route::delete('/peserta/{nim}', [PesertaController::class, 'destroy'])->name('peserta.destroy');
        Route::put('/peserta/{nim}', [PesertaController::class, 'update'])->name('peserta.update');
        Route::resource('instansi', instansiController::class);
        Route::resource('penyelia', penyeliaController::class);
    });

    // Route::group(['middleware' => ['penyelia']], function(){
    //     Route::get('/uspenyelia/{id_penyelia}/index', [DashboardController::class, 'daftarMahasiswaPenyelia'])->name('uspenyelia.index');
    // });
    
    // Route::get('/admin', [AdminController::class, 'index']);
    // Route::get('/admin/operator', [AdminController::class, 'operator'])->middleware('userAkses:operator');
    // Route::get('/admin/peserta', [AdminController::class, 'peserta'])->middleware('userAkses:peserta');
    // Route::get('/admin/penyelia', [AdminController::class, 'penyelia'])->middleware('userAkses:penyelia');
    //Route::get('/logout', [SesiController::class, 'logout']);
});


// Route::post('/', [SesiController::class, 'login']);
// Route::resource('peserta', PesertaController::class);
// Route::resource('instansi', instansiController::class);
// Route::resource('penyelia', penyeliaController::class);
// Route::resource('operator', opController::class);
// Route::resource('uspenyelia', listPeserta::class);
// Route::get('/profiladmin', [DashboardController::class, 'profilAdmin']);
// Route::get('/profiladmin', [DashboardController::class, 'jumlahPeserta']);
// Route::get('/profilpenyelia', [DashboardController::class, 'profilPenyelia']);
// Route::get('/profilpeserta', [DashboardController::class, 'profilPeserta']);
//Route::get('/dashboardpeserta', [DashboardController::class, 'dashboardPeserta']);
//Route::get('/home', [HomeController::class, 'showHome']);
//Route::get('/dashboardadmin', [DashboardController::class, 'showDashboardAdmin']);
//Route::get('/dashboard', 'AdminController@jmlPeserta');
// Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');