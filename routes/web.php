<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\PurchasingController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\InventoryController;
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
        Route::get('/', [SalesController::class, 'index'])->name('index');
        Route::get('/create', [SalesController::class, 'create'])->name('create');
        Route::post('/', [SalesController::class, 'store'])->name('store');
        Route::get('/{sales}', [SalesController::class, 'show'])->name('show');
        Route::get('/{sales}/edit', [SalesController::class, 'edit'])->name('edit');
        Route::put('/{sales}', [SalesController::class, 'update'])->name('update');
        Route::delete('/{sales}', [SalesController::class, 'destroy'])->name('destroy');
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
        Route::get('/', [ReportsController::class, 'index'])->name('index');
        Route::get('/sales', [ReportsController::class, 'sales'])->name('sales');
        Route::get('/purchasing', [ReportsController::class, 'purchasing'])->name('purchasing');
        Route::get('/service', [ReportsController::class, 'service'])->name('service');
        Route::get('/inventory', [ReportsController::class, 'inventory'])->name('inventory');
        Route::get('/finance', [ReportsController::class, 'finance'])->name('finance');
    });
    
    // Inventory routes
    Route::prefix('inventory')->name('inventory.')->group(function () {
        Route::get('/', [InventoryController::class, 'index'])->name('index');
        Route::get('/create', [InventoryController::class, 'create'])->name('create');
        Route::post('/', [InventoryController::class, 'store'])->name('store');
        Route::get('/{inventory}', [InventoryController::class, 'show'])->name('show');
        Route::get('/{inventory}/edit', [InventoryController::class, 'edit'])->name('edit');
        Route::put('/{inventory}', [InventoryController::class, 'update'])->name('update');
        Route::delete('/{inventory}', [InventoryController::class, 'destroy'])->name('destroy');
    });
});

require __DIR__.'/auth.php';