<?php

use Illuminate\Support\Facades\Route;

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
});

Route::get('/admin', function () {
    return redirect('/admin/dashboard');
});

Route::get('/admin/dashboard', function () {
    return view('admin.dashboard');
})->name('admin.dashboard');

Route::get('/admin/pendaftar', function () {
    return view('admin.pendaftar.index');
})->name('admin.pendaftar.index');

Route::get('/admin/pengumuman', function () {
    return 'Halaman Pengumuman (Coming Soon)';
})->name('admin.pengumuman.index');

Route::get('/admin/laporan', function () {
    return 'Halaman Laporan (Coming Soon)';
})->name('admin.laporan.index');

Route::get('/admin/akun', function () {
    return 'Halaman Akun (Coming Soon)';
})->name('admin.akun.index');

Route::post('/logout', function () {
    return redirect('/');
})->name('logout');

