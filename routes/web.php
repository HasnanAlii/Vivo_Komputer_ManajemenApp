<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\FinanceController;
use App\Http\Controllers\MoneyOutController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PurchasingController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\ShoppingController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;


Route:: get ('/storage-link', function (){
Artisan:: call('storage:link');
return 'Storage linked successfully.';
});

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
        Route::post('sales/checkout', [SaleController::class, 'checkout'])->name('checkout');
        Route::patch('/sales/{id}/increase', [SaleController::class, 'increase'])->name('increase');
        Route::patch('/sales/{id}/decrease', [SaleController::class, 'decrease'])->name('decrease');
        Route::get('/sales/print/{id}', [SaleController::class, 'printReceipt'])->name('print');
        Route::put('/sales/{id}/update-bayar', [SaleController::class, 'updateBayar'])->name('updateBayar');
        Route::get('/products/search', [SaleController::class, 'searchProducts'])->name('search');
        Route::patch('/sales/edit-price/{id}', [SaleController::class, 'editPrice'])->name('editPrice');
        Route::get('/sales/search-customer', [SaleController::class, 'searchCustomer'])->name('customer');
        Route::get('/sales/employee', [SaleController::class, 'searchEmployee'])->name('employee');
        Route::post('/customer', [CustomerController::class, 'store'])->name('addcustomer');
        Route::get('/create', [CustomerController::class, 'create'])->name('add');
    });

     Route::prefix('finances')->name('finances.')->group(function () {
        Route::get('/', [FinanceController::class, 'index'])->name('index');
        Route::get('/finances/print', [FinanceController::class, 'exportPDF'])->name('print');
        Route::get('/create', [FinanceController::class, 'create'])->name('create');
        Route::post('/', [FinanceController::class, 'store'])->name('store');
        Route::post('/+', [FinanceController::class, 'storee'])->name('storee');
        Route::get('/moneyOut', [MoneyOutController::class, 'index'])->name('indexx');
        Route::get('/finances/MoneyOut', [MoneyOutController::class, 'exportPDFF'])->name('printt');

    });
    
    // Purchasing routes
    Route::prefix('purchasing')->name('purchasing.')->group(function () {
        Route::get('/', [PurchasingController::class, 'index'])->name('index');
        Route::get('/purchasing/{purchasing}', [PurchasingController::class, 'show'])->name('show');
        Route::get('/create', [PurchasingController::class, 'create'])->name('create');
        Route::get('/createe', [PurchasingController::class, 'createe'])->name('createe');
        Route::post('/', [PurchasingController::class, 'store'])->name('store');
        Route::post('/langganan', [PurchasingController::class, 'storee'])->name('storee');
        // Route::get('/{purchasing}{id}', [PurchasingController::class, 'show'])->name('show');
        Route::get('/{purchasing}/edit', [PurchasingController::class, 'edit'])->name('edit');
        Route::put('/{purchasing}', [PurchasingController::class, 'update'])->name('update');
        Route::delete('/{purchasing}', [PurchasingController::class, 'destroy'])->name('destroy');
    });
    
    // Service routes
    Route::prefix('service')->name('service.')->group(function () {
        Route::get('/', [ServiceController::class, 'index'])->name('index');
        Route::get('/create', [ServiceController::class, 'create'])->name('create');
        Route::post('/', [ServiceController::class, 'store'])->name('store');
        Route::get('/{service}/edit', [ServiceController::class, 'edit'])->name('edit');
        Route::put('/{service}', [ServiceController::class, 'update'])->name('update');
        Route::delete('/{service}', [ServiceController::class, 'destroy'])->name('destroy');
        Route::get('/service/struk/{id}', [ServiceController::class, 'struk'])->name('struk');
        Route::get('/service/label/{id}', [ServiceController::class, 'label'])->name('label');
        Route::get('/createe', [ServiceController::class, 'createe'])->name('createe');
        Route::post('/langganan', [ServiceController::class, 'storee'])->name('storee');


    });
    
    // Reports routes
    Route::prefix('reports')->name('reports.')->group(function () {
        Route::get('/', [ReportController::class, 'index'])->name('index');
        Route::get('/purchasings', [PurchasingController::class, 'indexx'])->name('purchasings');
        Route::get('/purchasing/print_purchasings', [ReportController::class, 'print'])->name('print');
        Route::get('/sales', [SaleController::class, 'indexx'])->name('sales');
        Route::get('/sales/print_sales', [ReportController::class, 'printt'])->name('printt');
        Route::get('/services', [ServiceController::class, 'indexx'])->name('services');
        Route::get('/sales/print_services', [ReportController::class, 'printtt'])->name('printtt');
        Route::get('/sales/customer', [ReportController::class, 'customers'])->name('customer');
        Route::get('/sales/customers', [ReportController::class, 'customer'])->name('customers');
        Route::delete('/{reports}', [ReportController::class, 'destroyy'])->name('destroyy');
        Route::get('/cicilan/bayar/{idCustomer}', [CustomerController::class, 'editCicilan'])->name('edit');
        Route::get('/cicilan/edit/{idCustomer}', [CustomerController::class, 'edit'])->name('editt');
        Route::post('/cicilan/update/{idCustomer}', [CustomerController::class, 'updateCicilan'])->name('update');
        Route::post('/cicilan/bayar/{idCustomer}', [CustomerController::class, 'update'])->name('updatee');

        Route::get('/print/{id}', [ReportController::class, 'cetakhutang'])->name('cetakhutang');


        Route::get('/shopping', [ShoppingController::class, 'index'])->name('shopping');
        Route::get('/shopping/create', [ShoppingController::class, 'create'])->name('shoppingcreate');
        Route::post('/shopping/store', [ShoppingController::class, 'store'])->name('store');
        Route::get('/{shopping}/edit', [ShoppingController::class, 'edit'])->name('edits'); 
        Route::put('/{shopping}', [ShoppingController::class, 'update'])->name('updates');  
        Route::delete('/{shopping}/destroy', [ShoppingController::class, 'destroy'])->name('destroysh'); 

    });

        Route::get('/employees', [EmployeeController::class, 'index'])->name('employees.index');
        Route::get('/employees/create', [EmployeeController::class, 'create'])->name('employees.create');
        Route::post('/employees', [EmployeeController::class, 'store'])->name('employees.store');
        Route::get('/employees/{id}', [EmployeeController::class, 'show'])->name('employees.show');
        Route::get('/employees/{id}/edit', [EmployeeController::class, 'edit'])->name('employees.edit');
        Route::put('/employees/{id}', [EmployeeController::class, 'update'])->name('employees.update');
        Route::delete('/employees/{id}', [EmployeeController::class, 'destroy'])->name('employees.destroy');



        Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
        Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');
        Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
        Route::get('/categories/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
        Route::put('/categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
        Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');

    
    // Inventory routes
    Route::prefix('product')->name('product.')->group(function () {
        Route::get('/', [ProductController::class, 'index'])->name('index');
        Route::get('/create', [ProductController::class, 'create'])->name('create');
        Route::post('/', [ProductController::class, 'store'])->name('store');
        Route::get('/{product}', [ProductController::class, 'show'])->name('show');
        Route::get('/{product}/edit', [ProductController::class, 'edit'])->name('edit');
        Route::get('/{product}/editharga', [ProductController::class, 'editt'])->name('editt');
        Route::put('/{product}', [ProductController::class, 'update'])->name('update');
        Route::put('/{product}/harga', [ProductController::class, 'updatee'])->name('updatee');
        Route::delete('/{product}', [ProductController::class, 'destroy'])->name('destroy');
        Route::post('/product/import', [ProductController::class, 'import'])->name('import');
        Route::get('/product/export', [ProductController::class, 'export'])->name('export');
 



    });
});

require __DIR__.'/auth.php';