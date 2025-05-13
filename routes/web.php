<?php

use App\Http\Controllers\FinanceController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PurchasingController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SaleController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Sales routes
    Route::prefix('sales')->name('sales.')->group(function () {
        Route::get('/', [SaleController::class, 'index'])->name('index');
        Route::get('/create', [SaleController::class, 'create'])->name('create');
        Route::post('/', [SaleController::class, 'store'])->name('store');
        Route::get('/{sales}', [SaleController::class, 'show'])->name('show');
        Route::get('/{sales}/edit', [SaleController::class, 'edit'])->name('edit');
        Route::put('/{sales}', [SaleController::class, 'update'])->name('update');
        Route::delete('/{sales}', [SaleController::class, 'destroy'])->name('destroy');
    });

     Route::prefix('finances')->name('finances.')->group(function () {
        Route::get('/', [FinanceController::class, 'index'])->name('index');
        Route::get('/create', [FinanceController::class, 'create'])->name('create');
        Route::post('/', [FinanceController::class, 'store'])->name('store');
        Route::get('/{sales}', [FinanceController::class, 'show'])->name('show');
        Route::get('/{sales}/edit', [FinanceController::class, 'edit'])->name('edit');
        Route::put('/{sales}', [FinanceController::class, 'update'])->name('update');
        Route::delete('/{sales}', [FinanceController::class, 'destroy'])->name('destroy');
    });
    
    // Purchasing routes
    Route::prefix('purchasing')->name('purchasing.')->group(function () {
        Route::get('/', [PurchasingController::class, 'index'])->name('index');
        Route::get('/create', [PurchasingController::class, 'create'])->name('create');
        Route::post('/', [PurchasingController::class, 'store'])->name('store');
        Route::get('/{purchasing}', [PurchasingController::class, 'show'])->name('show');
        Route::get('/{purchasing}/edit', [PurchasingController::class, 'edit'])->name('edit');
        Route::put('/{purchasing}', [PurchasingController::class, 'update'])->name('update');
        Route::delete('/{purchasing}', [PurchasingController::class, 'destroy'])->name('destroy');
    });
    
    // Service routes
    Route::prefix('service')->name('service.')->group(function () {
        Route::get('/', [ServiceController::class, 'index'])->name('index');
        Route::get('/create', [ServiceController::class, 'create'])->name('create');
        Route::post('/', [ServiceController::class, 'store'])->name('store');
        Route::get('/{service}', [ServiceController::class, 'show'])->name('show');
        Route::get('/{service}/edit', [ServiceController::class, 'edit'])->name('edit');
        Route::put('/{service}', [ServiceController::class, 'update'])->name('update');
        Route::delete('/{service}', [ServiceController::class, 'destroy'])->name('destroy');
    });
    
    // Reports routes
    Route::prefix('reports')->name('reports.')->group(function () {
        Route::get('/', [ReportController::class, 'index'])->name('index');
        Route::get('/sales', [ReportController::class, 'sales'])->name('sales');
        Route::get('/purchasing', [ReportController::class, 'purchasing'])->name('purchasing');
        Route::get('/service', [ReportController::class, 'service'])->name('service');
        Route::get('/inventory', [ReportController::class, 'inventory'])->name('inventory');
        Route::get('/finance', [ReportController::class, 'finance'])->name('finance');
    });
    
    // Inventory routes
    Route::prefix('inventory')->name('inventory.')->group(function () {
        Route::get('/', [ProductController::class, 'index'])->name('index');
        Route::get('/create', [ProductController::class, 'create'])->name('create');
        Route::post('/', [ProductController::class, 'store'])->name('store');
        Route::get('/{inventory}', [ProductController::class, 'show'])->name('show');
        Route::get('/{inventory}/edit', [ProductController::class, 'edit'])->name('edit');
        Route::put('/{inventory}', [ProductController::class, 'update'])->name('update');
        Route::delete('/{inventory}', [ProductController::class, 'destroy'])->name('destroy');
    });
});

require __DIR__.'/auth.php';