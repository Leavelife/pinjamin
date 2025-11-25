<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\BorrowController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\AdminItemController;
use App\Http\Controllers\Admin\AdminBorrowController;
use App\Http\Controllers\Admin\AdminCategoryController;

Route::get('/', function () {
    return view('dashboard', [
        'categories' => \App\Models\Category::all()
    ]);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // items CRUD routes
    Route::get('/items-form', function () {
        return view('items-form', [
            'categories' => \App\Models\Category::all()
        ]);
    })->name('items-form');
    Route::resource('items', ItemController::class);
    Route::post('items.store', [ItemController::class, 'store'])->name('items.store');

    // Borrow routes
    Route::controller(BorrowController::class)->group(function () {
        Route::get('/borrow', 'index')->name('borrow.index'); // List barang untuk dipinjam
        Route::get('/borrow/create/{id}', 'create')->name('borrow.create'); // Form peminjaman
        Route::post('/borrow/{id}', 'store')->name('borrow.store'); // Submit peminjaman
        Route::get('/borrow/status', 'status')->name('borrow.status'); // Status peminjaman saya
        Route::get('/borrow-requests', 'requests')->name('borrow.requests'); // Permintaan peminjaman untuk barang saya
        Route::post('/borrow/{id}/approve', 'approve')->name('borrow.approve'); // Approve permintaan
        Route::post('/borrow/{id}/reject', 'reject')->name('borrow.reject'); // Reject permintaan
        Route::post('/borrow/{id}/mark-borrowed', 'markBorrowed')->name('borrow.mark-borrowed'); // Mark dimulai peminjaman
        Route::post('/borrow/{id}/mark-returned', 'markReturned')->name('borrow.mark-returned'); // Mark barang dikembalikan
    }); 

    Route::prefix('admin')->middleware('admin')->group(function () {

        Route::get('/', fn() => view('admin.dashboard'))->name('admin.dashboard');

        Route::resource('users', AdminUserController::class);
        Route::resource('items', AdminItemController::class);
        Route::resource('borrow', AdminBorrowController::class);
        Route::resource('categories', AdminCategoryController::class);
    });
});

require __DIR__.'/auth.php';
