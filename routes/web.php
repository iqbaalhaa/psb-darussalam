<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\SantriController;

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
    return view('home.index');
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
    Route::post('/santri/password/update', [SantriController::class, 'changePassword'])->name('password.update');
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');

    Route::get('/admin/pendaftar', [RegistrationController::class, 'index'])->name('admin.pendaftar.index');
    Route::get('/admin/pendaftar/{id}', [RegistrationController::class, 'show'])->name('admin.pendaftar.show');
    Route::put('/admin/pendaftar/{id}', [RegistrationController::class, 'update'])->name('admin.pendaftar.update');
    Route::delete('/admin/pendaftar/{id}', [RegistrationController::class, 'destroy'])->name('admin.pendaftar.destroy');


    Route::get('/admin/pengumuman', function () {
        return 'Halaman Pengumuman (Coming Soon)';
    })->name('admin.pengumuman.index');

    Route::get('/admin/laporan', function () {
        return 'Halaman Laporan (Coming Soon)';
    })->name('admin.laporan.index');

    Route::get('/admin/akun', function () {
        return 'Halaman Akun (Coming Soon)';
    })->name('admin.akun.index');
});
