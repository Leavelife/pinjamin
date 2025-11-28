<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\Http\Controllers\ItemController;
use App\Http\Controllers\BorrowController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminDashboardController;

/*
|--------------------------------------------------------------------------
| Web Routess
|--------------------------------------------------------------------------
*/

// ----------------------------------------------
// 1. PUBLIC PAGES (tidak perlu login)
// ----------------------------------------------

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::view('/onboarding', 'onboarding')->name('onboarding');
Route::view('/role-selection', 'role-selection')->name('role.selection');
Route::view('/login', 'auth.login')->name('login');
Route::view('/register', 'auth.register')->name('register');

// Proses Login / Register
Route::post('/login', [App\Http\Controllers\Auth\LoginController::class, 'login'])->name('login');
Route::post('/register', [App\Http\Controllers\Auth\RegisterController::class, 'register'])->name('register');

// ✅ TAMBAH ROUTE PASSWORD RESET:
Route::get('/forgot-password', function () {
    return view('auth.passwords.email');
})->middleware('guest')->name('password.request');

Route::post('/forgot-password', function (Request $request) {
    // TODO: Implementasi logic kirim email reset password
    return back()->with('status', 'Link reset password telah dikirim ke email Anda');
})->middleware('guest')->name('password.email');

// ✅ TAMBAH ROUTE RESET PASSWORD:
Route::get('/reset-password/{token}', function ($token) {
    return view('auth.passwords.reset', ['token' => $token]);
})->middleware('guest')->name('password.reset');

Route::post('/reset-password', function (Request $request) {
    // TODO: Implementasi logic update password di database
    return redirect()->route('login')->with('status', 'Password berhasil direset!');
})->middleware('guest')->name('password.update');

// Logout
Route::post('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/');
})->name('logout');

// Dashboard publik
Route::view('/dashboard', 'user.dashboard')->name('dashboard');

// Halaman pinjam barang (list barang)
Route::view('/pinjam', 'user.pinjam')->name('pinjam');

// Detail barang
Route::get('/barang/{barang}', [BarangController::class, 'show'])->name('barang.detail');

// Form menawarkan barang (PUBLIC)
Route::get('/tawarkan-barang', [BarangController::class, 'create'])->name('barang.create');

// Riwayat (public)
Route::get('/riwayat', [HistoryController::class, 'index'])->name('riwayat');

// Notifikasi (public)
Route::get('/notifikasi', [NotificationController::class, 'index'])->name('notifikasi');
Route::post('/notifikasi/{id}/read', [NotificationController::class, 'markRead'])->name('notifikasi.read');


// ----------------------------------------------
// 2. ROUTE UNTUK USER (BUTUH LOGIN)
// ----------------------------------------------
Route::middleware(['auth'])->group(function () {

    // Ajukan peminjaman
    Route::post('/barang/{barang}/ajukan', [BarangController::class, 'ajukanPeminjaman'])
        ->name('barang.ajukan');
    
    // Simpan barang yg ditawarkan
    Route::post('/tawarkan-barang', [BarangController::class, 'store'])
        ->name('barang.store');

    // Route lainnya...
});


// ----------------------------------------------
// 3. ADMIN ROUTES
// ----------------------------------------------
// ADMIN DASHBOARD (tanpa login)
Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');

// ADMIN ROUTES (dengan middleware auth & admin untuk action lainnya)
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::post('/peminjaman/{id}/approve', [AdminDashboardController::class, 'approvePeminjaman'])->name('approve-peminjaman');
    Route::post('/peminjaman/{id}/reject', [AdminDashboardController::class, 'rejectPeminjaman'])->name('reject-peminjaman');
    Route::post('/user/{id}/block', [AdminDashboardController::class, 'blockUser'])->name('block-user');
    Route::post('/user/{id}/unblock', [AdminDashboardController::class, 'unblockUser'])->name('unblock-user');
    Route::get('/user/{id}/activity', [AdminDashboardController::class, 'userActivity'])->name('user-activity');
});

// ✅ PROFIL USER (TIDAK PERLU LOGIN)
Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');

// Form edit profile (jika ada method edit)
Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');

// Update profile
Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');

Route::get('/manajemen-barang', [BarangController::class, 'manajemen'])->name('barang.manajemen');

// PUBLIC ROUTES (tidak perlu login)
Route::get('/manajemen-barang', [BarangController::class, 'manajemen'])->name('barang.manajemen');

// atau jika mau hanya user tertentu bisa edit:
Route::middleware(['auth'])->group(function () {
    Route::get('/barang/create', [BarangController::class, 'create'])->name('barang.create');
    Route::post('/barang', [BarangController::class, 'store'])->name('barang.store');
    Route::get('/barang/{barang}/edit', [BarangController::class, 'edit'])->name('barang.edit');
    Route::put('/barang/{barang}', [BarangController::class, 'update'])->name('barang.update');
    Route::delete('/barang/{barang}', [BarangController::class, 'destroy'])->name('barang.destroy');
});

// Public route untuk detail & list
Route::get('/barang', [BarangController::class, 'index'])->name('barang.index');
Route::get('/barang/{barang}', [BarangController::class, 'show'])->name('barang.show');


