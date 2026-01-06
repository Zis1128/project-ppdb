<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\PendaftaranController;
use App\Http\Controllers\Frontend\DashboardController;
use App\Http\Controllers\Frontend\ProfilController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;

// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/tentang', [HomeController::class, 'tentang'])->name('tentang');
Route::get('/jurusan', [HomeController::class, 'jurusan'])->name('jurusan');
Route::get('/alur-pendaftaran', [HomeController::class, 'alurPendaftaran'])->name('alur-pendaftaran');
Route::get('/kontak', [HomeController::class, 'kontak'])->name('kontak');
Route::post('/kontak', [HomeController::class, 'kontakStore'])->name('kontak.store');

// Auth Routes
Route::middleware(['guest'])->group(function () {
    Route::get('/register', [RegisterController::class, 'create'])->name('register');
    Route::post('/register', [RegisterController::class, 'store']);
    Route::get('/login', [LoginController::class, 'create'])->name('login');
    Route::post('/login', [LoginController::class, 'store']);
});

Route::post('/logout', [LoginController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

// Dashboard Routes (Protected)
Route::middleware(['auth'])->prefix('dashboard')->name('dashboard.')->group(function () {
    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('index');
    
    // Profil Routes
    Route::prefix('profil')->name('profil.')->group(function () {
        Route::get('/', [ProfilController::class, 'index'])->name('index');
        Route::put('/', [ProfilController::class, 'update'])->name('update');
        Route::delete('/foto', [ProfilController::class, 'deleteFoto'])->name('delete-foto');
        Route::get('/ubah-password', [ProfilController::class, 'ubahPassword'])->name('ubah-password');
        Route::put('/ubah-password', [ProfilController::class, 'updatePassword'])->name('update-password');
    });
    
    // Pendaftaran Routes
    Route::prefix('pendaftaran')->name('pendaftaran.')->group(function () {
        Route::get('/', [PendaftaranController::class, 'index'])->name('index');
        Route::get('/create', [PendaftaranController::class, 'create'])->name('create');
        Route::post('/', [PendaftaranController::class, 'store'])->name('store');
        Route::get('/{pendaftaran}/edit', [PendaftaranController::class, 'edit'])->name('edit');
        Route::put('/{pendaftaran}', [PendaftaranController::class, 'update'])->name('update');
        Route::post('/{pendaftaran}/submit', [PendaftaranController::class, 'submit'])->name('submit');
        Route::get('/{pendaftaran}/dokumen', [PendaftaranController::class, 'dokumen'])->name('dokumen');
    });
    
    // Cetak Routes
    Route::get('/cetak/formulir', [PendaftaranController::class, 'cetakFormulir'])->name('cetak.formulir');
    Route::get('/cetak/kartu', [PendaftaranController::class, 'cetakKartu'])->name('cetak.kartu');

    // Pembayaran Routes - FIXED (Konsisten pakai PendaftaranController::class)
    Route::prefix('pembayaran')->name('pembayaran.')->group(function () {
        Route::get('/', [PendaftaranController::class, 'pembayaran'])->name('index');
        Route::post('/upload', [PendaftaranController::class, 'uploadBukti'])->name('upload');
        
        // Midtrans Routes
        Route::post('/midtrans', [PendaftaranController::class, 'payWithMidtrans'])->name('midtrans');
        Route::get('/finish', [PendaftaranController::class, 'paymentFinish'])->name('finish');
        Route::post('/finish', [PendaftaranController::class, 'paymentFinish']); // Support POST juga
        Route::get('/success', [PendaftaranController::class, 'paymentSuccess'])->name('success');
        Route::get('/pending', [PendaftaranController::class, 'paymentPending'])->name('pending');
        Route::get('/failed', [PendaftaranController::class, 'paymentFailed'])->name('failed');
        
        // Auto-verify route - FIXED
        Route::post('/auto-verify', [PendaftaranController::class, 'autoVerify'])->name('auto-verify');
    });
    
    // Test Livewire
    Route::get('/test-livewire', function() {
        return view('test-livewire');
    });
});

// Midtrans Webhook (No Auth)
Route::post('/webhook/midtrans', [PendaftaranController::class, 'paymentWebhook'])->name('webhook.midtrans');