<?php

use App\Http\Controllers\PengumumanController;
use App\Http\Controllers\HomeSettingController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\SantriController;
use Illuminate\Support\Facades\Auth;
use App\Models\Registration;
use Barryvdh\DomPDF\Facade\Pdf;


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

Route::get('/', function () {
    $tahunAktif = \App\Models\TahunAjaran::where('is_active', 1)->first();
    return view('home.index', compact('tahunAktif'));
})->name('home');

// Auth Routes
Route::get('/admin', [AuthController::class, 'login'])->name('login');
Route::post('/admin', [AuthController::class, 'authenticate'])->name('login.authenticate');
Route::post('/login', [AuthController::class, 'authenticate'])->name('login.public'); // Public login
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Registration Routes
Route::post('/register', [RegistrationController::class, 'store'])->name('register.store');

Route::middleware(['auth', 'role:santri'])->group(function () {
    Route::get('/santri/dashboard', [SantriController::class, 'dashboard'])->name('santri.dashboard');
    Route::put('/santri/update', [SantriController::class, 'update'])->name('santri.update');
    Route::get('/santri/password/change', [SantriController::class, 'showChangePasswordForm'])->name('password.change');
    // Route::post('/santri/password/update', [SantriController::class, 'changePassword'])->name('password.update');
    Route::post('register/update-password/{id}', [RegistrationController::class, 'changePassword']);

});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', function () {

        $totalPendaftarTahunIni = Registration::where('tahun_ajaran', date('Y'))->count();
        $dataPending = Registration::where('status', 'pending')->count();
        $dataBerkasBlmLengkap = Registration::where('status', 'incomplete_file')->count();
        $dataDitolak = Registration::where('status', 'reject')->count();
        $dataDiterima = Registration::where('status', 'accept')->count();

        // $ = Registration::where('tahun_ajaran', date('Y'))->count();

        return view('admin.dashboard', [
            'totalPendaftar' => $totalPendaftarTahunIni,
            'totalPending' => $dataPending,
            'totalBerkasBlmLengkap' => $dataBerkasBlmLengkap,
            'totalDitolak' => $dataDitolak,
            'totalDiterima' => $dataDiterima,
        ]);
    })->name('admin.dashboard');

    Route::get('/admin/pendaftar', [RegistrationController::class, 'index'])->name('admin.pendaftar.index');
    Route::get('/admin/pendaftar/{id}', [RegistrationController::class, 'show'])->name('admin.pendaftar.show');
    Route::put('/admin/pendaftar/{id}', [RegistrationController::class, 'update'])->name('admin.pendaftar.update');
    Route::delete('/admin/pendaftar/{id}', [RegistrationController::class, 'destroy'])->name('admin.pendaftar.destroy');

    Route::get('/admin/detail-pendaftar/{id}', [RegistrationController::class, 'detail']);
    Route::post('/admin/update-status-pendaftaran/{id}', [RegistrationController::class, 'updateStatus']);
    Route::post('/admin/export-pendaftar', [RegistrationController::class, 'export'])->name('admin.export.process');

    Route::get('/admin/edit-pendaftar/{id}', [RegistrationController::class, 'edit']);
    Route::put('/admin/update-pendaftar/{id}', [RegistrationController::class, 'updateDataRegister']);

    Route::post('/admin/update-status-pembayaran/{id}', [RegistrationController::class, 'updateStatusPembayaran']);
    
    Route::get('/form-pendaftaran-pdf/{id}', [RegistrationController::class, 'dokPendaftaran']);
    Route::get('/form-pernyataan-pdf/{id}', [RegistrationController::class, 'dokPernyataan']);
    Route::get('/form-janji-santri-pdf/{id}', [RegistrationController::class, 'dokJanjiSantri']);
    Route::get('/form-syarat-pendaftaran', [RegistrationController::class, 'dokSyaratPendaftaran']);

    // Pengumuman : 
    Route::get("/admin/pengumuman", [PengumumanController::class, 'index'])->name('admin.pengumuman.index');
    Route::get("/admin/pengumuman/create", [PengumumanController::class, 'create'])->name('admin.pengumuman.create');
    Route::post("/admin/pengumuman", [PengumumanController::class, 'store']);
    Route::get("/admin/pengumuman/{pengumuman}", [PengumumanController::class, 'edit']);
    Route::patch("/admin/pengumuman/{pengumuman}", [PengumumanController::class, 'update']);
    Route::delete("/admin/pengumuman/{pengumuman}", [PengumumanController::class, 'destroy']);
    // Route::get("/admin/pengumuman", [PengumumanController::class, 'index']);
    // Route::get("/admin/pengumuman", [PengumumanController::class, 'index']);
    // Route::get("/admin/pengumuman", [PengumumanController::class, 'index']);


    Route::get('/admin/tahun', [\App\Http\Controllers\TahunAjaranController::class, 'index'])->name('admin.tahun.index');
    Route::post('/admin/tahun', [\App\Http\Controllers\TahunAjaranController::class, 'store'])->name('admin.tahun.store');
    Route::patch('/admin/tahun/{id}/status', [\App\Http\Controllers\TahunAjaranController::class, 'updateStatus'])->name('admin.tahun.updateStatus');
    Route::delete('/admin/tahun/{id}', [\App\Http\Controllers\TahunAjaranController::class, 'destroy'])->name('admin.tahun.destroy');

    // Route::get('/admin/pengumuman', function () {
    //     return 'Halaman Pengumuman (Coming Soon)';
    // })->name('admin.pengumuman.index');

    Route::get('/admin/laporan', [\App\Http\Controllers\LaporanController::class, 'index'])->name('admin.laporan.index');
    Route::get('/admin/laporan/print', [\App\Http\Controllers\LaporanController::class, 'print'])->name('admin.laporan.print');

    // Home CMS
    Route::get('/admin/home-settings', [HomeSettingController::class, 'edit'])->name('admin.home-settings.edit');
    Route::put('/admin/home-settings', [HomeSettingController::class, 'update'])->name('admin.home-settings.update');

    // Route Akun Management
    Route::get('/admin/akun', [\App\Http\Controllers\AccountController::class, 'index'])->name('admin.akun.index');
    Route::post('/admin/akun', [\App\Http\Controllers\AccountController::class, 'store'])->name('admin.akun.store');
    Route::put('/admin/akun/{id}', [\App\Http\Controllers\AccountController::class, 'update'])->name('admin.akun.update');
    Route::delete('/admin/akun/{id}', [\App\Http\Controllers\AccountController::class, 'destroy'])->name('admin.akun.destroy');
});

// Test Pdf :
// Route::get('/form-pendaftaran-pdf/{id}', function ($id) {

//     $data = Registration::findOrFail($id);

//     $pdf = Pdf::loadView('admin.pendaftar.form_pendaftaran', [
//         'data' => $data,
//     ])->setPaper('A4', 'portrait');

//     return $pdf->stream('formulir-pendaftaran-dummy.pdf');
// });

// Route::get('/form-pernyataan-pdf', function () {
//     $pdf = Pdf::loadView('admin.pendaftar.form_pernyataan')
//         ->setPaper('A4', 'portrait');

//     return $pdf->stream('formulir-pernyataan-dummy.pdf');
// });

// Route::get('/form-janji-santri-pdf/{id}', function ($id) {

//     $data = Registration::findOrFail($id);

//     return Pdf::loadView(
//         'admin.pendaftar.form_janji_santri',
//         compact('data')
//     )->stream('surat-pernyataan-dan-janji-santri.pdf');
// });

// Route::get('/form-syarat-pendaftaran', function () {
//     return Pdf::loadView(
//         'admin.pendaftar.form_syarat_pendaftaran'
//     )->setPaper('A4', 'portrait')
//         ->stream('syarat-pendaftaran.pdf');
// });
