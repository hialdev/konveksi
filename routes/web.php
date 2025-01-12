<?php

use App\Http\Controllers\Auth\ConfirmPasswordController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\BankController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\CustomOrderController;
use App\Http\Controllers\CustomOrderPaymentController;
use App\Http\Controllers\FlyerController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PurchaseRawMaterialController;
use App\Http\Controllers\RawMaterialController;
use App\Http\Controllers\RequestProductionController;
use App\Http\Controllers\ReturController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
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

// Route::get('/', function(){
//     return redirect()->route('home');
// });
Route::get('/app.css', function () {
    $theme = config('al.theme'); // Memuat konfigurasi tema
    return response()
        ->view('styles.app', ['theme' => $theme])
        ->header('Content-Type', 'text/css');
});

// -------------- Auth Routes ----------------
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/password/confirm', [ConfirmPasswordController::class, 'showConfirmForm'])->name('password.confirm');
Route::post('/password/confirm', [ConfirmPasswordController::class, 'confirm']);
Route::post('/password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('/password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('/password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');
Route::get('/password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

//Auth::routes();
// -------------- End Auth Routes ----------------

// -------------- Unauthenticated routes ------------------
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'index'])->name('dashboard');
Route::get('/status/{id}', [FlyerController::class, 'status'])->name('flyer.status');
Route::get('/etalase',[ProductController::class, 'etalase'])->name('product.etalase');
Route::get('/etalase/{slug}',[ProductController::class, 'show'])->name('product.show');
Route::post('/etalase/add-to-cart',[ProductController::class, 'addCart'])->name('product.addCart');
Route::post('/etalase/min-qty',[ProductController::class, 'minQty'])->name('product.minQty');
Route::post('/etalase/add-qty',[ProductController::class, 'addQty'])->name('product.addQty');

Route::get('/order/add', [OrderController::class, 'add'])->name('order.add');

Route::middleware(['auth'])->group(function(){
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile/edit', [ProfileController::class, 'update'])->name('profile.update');

    Route::get('/order',[OrderController::class, 'index'])->name('order.index');
    Route::get('/order/my',[OrderController::class, 'my'])->name('order.my');
    Route::get('/order/waiting',[OrderController::class, 'waiting'])->name('order.waiting');
    Route::post('/order/checkout',[OrderController::class, 'checkout'])->name('order.checkout');
    Route::get('/order/{id}/payment',[OrderController::class, 'payment'])->name('order.payment');
    Route::post('/order/{id}/paid',[OrderController::class, 'paid'])->name('order.paid');
    Route::post('/order/{id}/reorder',[OrderController::class, 'reorder'])->name('order.reorder');
    Route::post('/order/{id}/approve',[OrderController::class, 'approve'])->name('order.approve');
    Route::post('/order/{id}/rejected',[OrderController::class, 'rejected'])->name('order.rejected');
    Route::post('/order/{id}/review',[OrderController::class, 'review'])->name('order.review');
    Route::post('/order/{id}/retur',[OrderController::class, 'retur'])->name('order.retur');
    
    Route::get('/product',[ProductController::class, 'index'])->name('product.index');
    Route::get('/raw-material',[RawMaterialController::class, 'index'])->name('raw_material.index');
    Route::get('/supplier',[SupplierController::class, 'index'])->name('supplier.index');

    Route::get('/flyer',[FlyerController::class, 'index'])->name('flyer.index');
    Route::get('/flyer/add',[FlyerController::class, 'add'])->name('flyer.add');
    Route::post('/flyer/store',[FlyerController::class, 'store'])->name('flyer.store');
    Route::get('/flyer/{id}/edit',[FlyerController::class, 'edit'])->name('flyer.edit');
    Route::post('/flyer/{id}/update',[FlyerController::class, 'update'])->name('flyer.update');
    Route::post('/flyer/{id}/seat',[FlyerController::class, 'seat'])->name('flyer.seat');
    Route::delete('/flyer/{id}/destroy',[FlyerController::class, 'destroy'])->name('flyer.destroy');
    Route::get('/flyer/{id}/qr-logo', [FlyerController::class, 'qrWithLogo'])->name('flyer.qrlogo');

    Route::get('/customer',[CustomerController::class, 'index'])->name('customer.index');
    Route::post('/customer/store',[CustomerController::class, 'store'])->name('customer.store');

    Route::get('/request-production',[RequestProductionController::class, 'index'])->name('request_production.index');
    Route::get('/request-production/add',[RequestProductionController::class, 'add'])->name('request_production.add');
    Route::post('/request-production/store',[RequestProductionController::class, 'store'])->name('request_production.store');
    Route::get('/request-production/{id}/edit',[RequestProductionController::class, 'edit'])->name('request_production.edit');
    Route::post('/request-production/{id}/update',[RequestProductionController::class, 'update'])->name('request_production.update');
    Route::post('/request-production/{id}/process',[RequestProductionController::class, 'process'])->name('request_production.process');

    Route::get('/custom-order', [CustomOrderController::class, 'index'])->name('custom-order.index');
    Route::get('/custom-order/waiting', [CustomOrderController::class, 'waiting'])->name('custom-order.waiting');
    Route::get('/custom-order/my', [CustomOrderController::class, 'my'])->name('custom-order.my');
    Route::get('/custom-order/add', [CustomOrderController::class, 'add'])->name('custom-order.add');
    Route::post('/custom-order/store', [CustomOrderController::class, 'store'])->name('custom-order.store');
    Route::get('/custom-order/{id}/edit', [CustomOrderController::class, 'edit'])->name('custom-order.edit');
    Route::post('/custom-order/{id}/update', [CustomOrderController::class, 'update'])->name('custom-order.update');
    Route::post('/custom-order/{id}/nego', [CustomOrderController::class, 'nego'])->name('custom-order.nego');
    Route::post('/custom-order/{id}/approve',[CustomorderController::class, 'approve'])->name('custom-order.approve');
    Route::post('/custom-order/{id}/rejected', [CustomOrderController::class, 'rejected'])->name('custom-order.rejected');

    Route::get('/custom-order/{id}/payment', [CustomOrderPaymentController::class, 'index'])->name('custom-order.payment.index');
    Route::middleware('check.sepakat')->group(function (){
        Route::post('/custom-order/{id}/payment/store', [CustomOrderPaymentController::class, 'store'])->name('custom-order.payment.store');
        Route::post('/custom-order/{id}/payment/{pay_id}/update', [CustomOrderPaymentController::class, 'update'])->name('custom-order.payment.update');
        Route::post('/custom-order/{id}/payment/{pay_id}/approve', [CustomOrderPaymentController::class, 'approve'])->name('custom-order.payment.approve');
        Route::post('/custom-order/{id}/payment/{pay_id}/rejected', [CustomOrderPaymentController::class, 'rejected'])->name('custom-order.payment.rejected');
        Route::delete('/custom-order/{id}/payment/{pay_id}/destroy', [CustomOrderPaymentController::class, 'destroy'])->name('custom-order.payment.destroy');
    });

    Route::middleware(['role:developer'])->group(function(){
        Route::delete('/setting/{id}/force',[SettingController::class, 'force'])->name('setting.force');
    });

    Route::middleware(['role:admin|developer|employee'])->group(function (){
        Route::delete('/request-production/{id}/destroy',[RequestProductionController::class, 'destroy'])->name('request_production.destroy');
        
        Route::delete('/customer/{id}/destroy',[CustomerController::class, 'destroy'])->name('customer.destroy');
        Route::post('/customer/{id}/update',[CustomerController::class, 'update'])->name('customer.update');
        
        Route::delete('/order/{id}/destroy',[OrderController::class, 'destroy'])->name('order.destroy');
        
        Route::post('/custom-order/{id}/putPrice',[CustomorderController::class, 'putPrice'])->name('custom-order.putPrice');
        Route::delete('/custom-order/{id}/destroy',[CustomorderController::class, 'destroy'])->name('custom-order.destroy');

        Route::post('/retur/{id}/approve',[ReturController::class, 'approve'])->name('retur.approve');
        Route::post('/retur/{id}/rejected',[ReturController::class, 'rejected'])->name('retur.rejected');

        Route::post('/raw-material/store',[RawMaterialController::class, 'store'])->name('raw_material.store');
        Route::get('/raw-material/add',[RawMaterialController::class, 'add'])->name('raw_material.add');
        Route::get('/raw-material/purchase',[PurchaseRawMaterialController::class, 'index'])->name('raw_material.purchase.index'); // Purchase Raw Material ke Supplier
        Route::get('/raw-material/purchase/add',[PurchaseRawMaterialController::class, 'add'])->name('raw_material.purchase.add'); // Purchase Raw Material ke Supplier
        Route::post('/raw-material/purchase/add',[PurchaseRawMaterialController::class, 'store'])->name('raw_material.purchase.store');
        Route::get('/raw-material/purchase/{id}/edit',[PurchaseRawMaterialController::class, 'edit'])->name('raw_material.purchase.edit'); // Purchase Raw Material ke Supplier
        Route::post('/raw-material/purchase/{id}/edit',[PurchaseRawMaterialController::class, 'update'])->name('raw_material.purchase.update'); // Purchase Raw Material ke Supplier
        Route::delete('/raw-material/purchase/{id}/destroy',[PurchaseRawMaterialController::class, 'destroy'])->name('raw_material.purchase.destroy'); // Purchase Raw Material ke Supplier
        Route::post('/raw-material/{id}/available',[RawMaterialController::class, 'available'])->name('raw_material.available');
        Route::get('/raw-material/{id}/edit',[RawMaterialController::class, 'edit'])->name('raw_material.edit');
        Route::post('/raw-material/{id}/update',[RawMaterialController::class, 'update'])->name('raw_material.update');
        Route::delete('/raw-material/{id}/destroy',[RawMaterialController::class, 'destroy'])->name('raw_material.destroy');

        Route::get('/product/add',[ProductController::class, 'add'])->name('product.add');
        Route::post('/product/store',[ProductController::class, 'store'])->name('product.store');
        Route::post('/product/category/store',[ProductController::class, 'categoryStore'])->name('product.category.store');
        Route::post('/product/stock/{id}/update',[ProductController::class, 'updateStock'])->name('product.stock');
        Route::get('/product/{id}/edit',[ProductController::class, 'edit'])->name('product.edit');
        Route::post('/product/{id}/update',[ProductController::class, 'update'])->name('product.update');
        Route::delete('/product/{id}/destroy',[ProductController::class, 'destroy'])->name('product.destroy');

        Route::post('/supplier/store',[SupplierController::class, 'store'])->name('supplier.store');
        Route::post('/supplier/{id}/update',[SupplierController::class, 'update'])->name('supplier.update');
        Route::delete('/supplier/{id}/destroy',[SupplierController::class, 'destroy'])->name('supplier.destroy');

        Route::get('/category',[ProductCategoryController::class, 'index'])->name('category.index');
        Route::post('/category/store',[ProductCategoryController::class, 'store'])->name('category.store');
        Route::post('/category/{id}/update',[ProductCategoryController::class, 'update'])->name('category.update');
        Route::delete('/category/{id}/destroy',[ProductCategoryController::class, 'destroy'])->name('category.destroy');

        Route::get('/user',[UserController::class, 'index'])->name('user.index');
        Route::get('/user/add',[UserController::class, 'add'])->name('user.add');
        Route::post('/user/store',[UserController::class, 'store'])->name('user.store');
        Route::get('/user/{id}/edit',[UserController::class, 'edit'])->name('user.edit');
        Route::post('/user/{id}/update',[UserController::class, 'update'])->name('user.update');
        Route::delete('/user/{id}/destroy',[UserController::class, 'destroy'])->name('user.destroy');

        Route::get('/bank',[BankController::class, 'index'])->name('bank.index');
        Route::get('/bank/add',[BankController::class, 'add'])->name('bank.add');
        Route::post('/bank/store',[BankController::class, 'store'])->name('bank.store');
        Route::get('/bank/{id}/edit',[BankController::class, 'edit'])->name('bank.edit');
        Route::post('/bank/{id}/update',[BankController::class, 'update'])->name('bank.update');
        Route::delete('/bank/{id}/destroy',[BankController::class, 'destroy'])->name('bank.destroy');

        Route::get('/setting',[SettingController::class, 'index'])->name('setting.index');
        Route::post('/setting',[SettingController::class, 'store'])->name('setting.store');
        Route::post('/setting/{id}',[SettingController::class, 'update'])->name('setting.update');
        Route::post('/setting/{id}/clear',[SettingController::class, 'clear'])->name('setting.clear');
        Route::delete('/setting/{id}',[SettingController::class, 'destroy'])->name('setting.destroy');
    });
});