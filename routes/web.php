<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\DashboardController;

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\AdminCategoryController;
use App\Http\Controllers\Admin\AdminProfileController;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\NotificationController;

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

Route::middleware(['auth'])->group(function () {

    // Dashboard
    Route::get('/dashboard', function () {
        return view('user.dashboard');
    })->name('dashboard');
    Route::get('/', function () {
        return view('user.dashboard');
    })->name('dashboard');
    

    // ============================
    // PROFILE
    // ============================
    Route::prefix('profile')->name('profile.')->group(function () {

        Route::get('/view', fn() => view('user.profile', ['user' => Auth::user(), 'totalDipinjam' => $totalDipinjam ?? 0,'totalDipinjamkan' => $totalDipinjamkan ?? 0]))->name('view.page');
        // Halaman profile (VIEW via controller)
        Route::get('/', [ProfileController::class, 'me'])->name('index');

        // Halaman edit profile (VIEW langsung)
        Route::get('/edit', function () {
            return view('user.profile_edit', ['user' => Auth::user()]);
        })->name('edit.page');

        // Update profile (POST)
        Route::post('/update', [ProfileController::class, 'update'])->name('update');

    });



    // ============================
    // BARANG SAYA
    // ============================
    Route::prefix('items')->name('items.')->group(function () {

        // Semua barang selain milik saya (UI: Pinjam Barang)
        Route::get('/all', [ItemController::class, 'index'])->name('all');
        Route::get('/', [ItemController::class, 'showItemsPage'])->name('index');

        // Barang saya
        Route::get('/mine', [ItemController::class, 'myItemsPage'])->name('mine');

        // Tambah barang
        Route::post('/store', [ItemController::class, 'store'])->name('store');

        // Detail barang
        Route::get('show/{id}', [ItemController::class, 'show'])->name('show.page');

        // Update barang saya
        Route::post('/{id}/update', [ItemController::class, 'update'])->name('update.page');

        // Hapus barang saya
        Route::delete('/{id}/delete', [ItemController::class, 'destroy'])->name('delete');
    });
    Route::get('/barang/create', fn() => view('barang.create'))->name('barang.create.page');

    // ============================
    // PEMINJAMAN / LOAN
    // ============================
    Route::prefix('loan')->name('loan.')->group(function () {

        // Ajukan pinjaman untuk barang tertentu
        Route::post('/request/{itemId}', [LoanController::class, 'requestLoan'])->name('request');

        // Riwayat pinjaman saya
        Route::get('/history', [LoanController::class, 'historyPage'])->name('history.page');

        // Detail pinjaman saya
        Route::get('/detail/{id}', [LoanController::class, 'detail'])->name('detail');
    });

    Route::get('/pinjam', fn() => view('user.pinjam'))->name('user.pinjam.page');
    Route::get('/manajemen-barang', [ItemController::class, 'myItemsPage'])
        ->middleware('auth')
        ->name('items.mine.page');

    // ============================
    // NOTIFIKASI
    // ============================
    Route::get('/notifications', fn() => view('user.notification'))->name('user.notification.page');
    Route::get('/notifications/{id}', [NotificationController::class, 'show'])->name('notifications.show');

    // Menandai notifikasi sebagai sudah dibaca (bisa dipakai AJAX)
    Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {

    // Dashboard
    Route::get('/stat', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');

    // User Management
    Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
    Route::delete('/users/{id}', [AdminUserController::class, 'destroy'])->name('users.delete');

    // Categories
    Route::get('/categories', [AdminCategoryController::class, 'index'])->name('categories.index');
    Route::post('/categories', [AdminCategoryController::class, 'store'])->name('categories.store');
    Route::get('/categories/{id}', [AdminCategoryController::class, 'show'])->name('categories.show');
    Route::post('/categories/{id}', [AdminCategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{id}', [AdminCategoryController::class, 'destroy'])->name('categories.delete');

    // Profile Admin
    Route::get('/profile', [AdminProfileController::class, 'me'])->name('profile.index');
    Route::post('/profile/update', [AdminProfileController::class, 'update'])->name('profile.update');
});
