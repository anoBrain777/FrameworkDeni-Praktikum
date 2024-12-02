<?php

use Illuminate\Http\Request;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SupplierController;
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
// SUPPLIER ROUTES
Route::middleware(['auth', 'RoleCheck:admin'])->group(function () {
    Route::get('/supplier', [SupplierController::class, 'index'])->name('supplier.index');
    Route::get('/supplier/create', [SupplierController::class, 'create'])->name("supplier-create");
    Route::post('/supplier', [SupplierController::class, 'store'])->name("supplier-store");
});

// PRODUCTS ROUTES
Route::middleware(['auth', 'RoleCheck:admin'])->group(function () {
    Route::get('/product', [ProductController::class, 'index'])->name("product-index");
    Route::get('/product/create', [ProductController::class, 'create'])->name("product-create");
    Route::post('/product', [ProductController::class, 'store'])->name("product-store");
    Route::get('/product/{id}', [ProductController::class, 'show']);
    Route::get('/product/{id}/edit', [ProductController::class, 'edit'])->name("product-edit");
    Route::put('/product/{id}', [ProductController::class, 'update'])->name("product-update");
    Route::delete('/product/{id}', [ProductController::class, 'destroy'])->name("product-deleted");
    Route::get('/products', [ProductController::class, 'index'])->name('product');
    

});

Route::get('/', function () {
    return view('welcome');
    });
    
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified','RoleCheck:admin'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::get('/product/export/excel', [ProductController::class,'exportExcel'])->name('product-export-excel');

require __DIR__.'/auth.php';
