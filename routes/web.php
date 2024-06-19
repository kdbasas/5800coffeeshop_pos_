<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\LoginController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\EmployeeMiddleware;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\GenderController;
use App\Http\Controllers\ProductTypeController;
use App\Http\Controllers\SellController;
use App\Http\Controllers\TransactionController;

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.submit');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware(['auth', 'admin'])->group(function () {
       
  Route::get('/admin/dashboard', function () {return view('admin.dashboard');})->name('admin.dashboard');
  Route::get('/admin/statistics', [AdminController::class, 'showStatistics'])->name('admin.statistics');
  Route::get('/admin/statistics/receipt', [AdminController::class, 'generateStatisticsReceipt'])->name('admin.statistics.receipt');
  Route::post('/admin/transactions', [TransactionController::class, 'store'])->name('transactions.store');
  Route::get('/admin/transactions/{transaction}/receipt', [TransactionController::class, 'showReceipt'])->name('transactions.showReceipt');
    Route::get('/admin/employee/create', [EmployeeController::class, 'create'])->name('admin.employee.create');
    Route::post('/admin/employee/store', [EmployeeController::class, 'store'])->name('admin.employee.store');
    Route::get('/admin/employee/{id}/edit', [EmployeeController::class, 'edit'])->name('admin.employee.edit');
    Route::put('/admin/employee/{employee}/update', [EmployeeController::class, 'update'])->name('admin.employee.update');
    Route::get('/admin/employee/{id}/delete', [EmployeeController::class, 'delete'])->name('admin.employee.delete');
    Route::delete('/admin/employee/{employee}/destroy', [EmployeeController::class, 'destroy'])->name('admin.employee.destroy');
    Route::get('/admin/employee/{employee}/show', [EmployeeController::class, 'show'])->name('admin.employee.show');
    Route::get('/admin/employee', [EmployeeController::class, 'index'])->name('admin.employee.index');
    Route::get('/admin/employee/employeelist/search', [EmployeeController::class, 'search'])->name('admin.employeelist.search');


    // Products
    Route::get('/admin/products/create', [ProductController::class, 'create'])->name('admin.product.create');
    Route::post('/admin/products/store', [ProductController::class, 'store'])->name('admin.product.store');
    Route::get('/admin/products/{id}/edit', [ProductController::class, 'edit'])->name('admin.product.edit');
    Route::put('/admin/products/{product}/update', [ProductController::class, 'update'])->name('admin.product.update');
    Route::get('/admin/products/{id}/delete', [ProductController::class, 'delete'])->name('admin.product.delete');
    Route::delete('/admin/products/{product}/destroy', [ProductController::class, 'destroy'])->name('admin.product.destroy');
    Route::get('/admin/products/{product}/show', [ProductController::class, 'show'])->name('admin.product.show');
    Route::get('/admin/products/productlist/search', [ProductController::class, 'search'])->name('admin.productlist.search');
    Route::get('/admin/products', [ProductController::class, 'index'])->name('admin.product.index');

     // Product Types
     Route::get('/admin/product-types', [ProductTypeController::class, 'index'])->name('admin.product_types.index');
     Route::get('/admin/product-types/create', [ProductTypeController::class, 'create'])->name('admin.product_types.create');
     Route::post('/admin/product-types', [ProductTypeController::class, 'store'])->name('admin.product_types.store');
     Route::get('/admin/product-types/{product_type}/edit', [ProductTypeController::class, 'edit'])->name('admin.product_types.edit');
     Route::put('/admin/product-types/{product_type}', [ProductTypeController::class, 'update'])->name('admin.product_types.update');
     Route::get('/admin/product-types/{id}/delete', [ProductTypeController::class, 'delete'])->name('admin.product_types.delete');
     Route::delete('/admin/product-types/{product_type}', [ProductTypeController::class, 'destroy'])->name('admin.product_types.destroy');
 
    // Genders
    Route::get('/admin/gender/create', [GenderController::class, 'create'])->name('admin.gender.create');
    Route::post('/admin/gender/store', [GenderController::class, 'store'])->name('admin.gender.store');
    Route::get('/admin/gender/{id}/edit', [GenderController::class, 'edit'])->name('admin.gender.edit');
    Route::put('/admin/gender/{id}/update', [GenderController::class, 'update'])->name('admin.gender.update');
    Route::get('/admin/gender/{id}/delete', [GenderController::class, 'delete'])->name('admin.gender.delete');
    Route::delete('/admin/gender/{gender}/destroy', [GenderController::class, 'destroy'])->name('admin.gender.destroy');
    Route::get('admin/gender/search', [GenderController::class,'search'] )->name('admin.gender.search');
    Route::get('/admin/gender/{id}/show', [GenderController::class, 'show'])->name('admin.gender.show');
    Route::get('/admin/gender', [GenderController::class, 'index'])->name('admin.gender.index');
});


Route::middleware(['auth', 'employee'])->group(function () {
 
Route::get('/employee/dashboard', function () {return view('employee.dashboard');})->name('employee.dashboard');
Route::get('/employee/sell', [SellController::class, 'index'])->name('employee.sell.index');
Route::post('/employee/sell/add-to-cart', [SellController::class, 'addToCart'])->name('employee.sell.addToCart');
Route::patch('/employee/sell/update-quantity/{id}', [SellController::class, 'updateQuantity'])->name('employee.sell.updateQuantity');
Route::delete('/employee/sell/remove-from-cart/{id}', [SellController::class, 'removeFromCart'])->name('employee.sell.removeFromCart');
Route::post('/employee/sell/clear-cart', [SellController::class, 'clearCart'])->name('employee.sell.clearCart');
Route::post('/employee/sell/checkout', [SellController::class, 'checkout'])->name('employee.sell.checkout');
Route::get('/employee/sell/filter-products', [SellController::class, 'filterProducts'])->name('employee.sell.filterProducts');

});







