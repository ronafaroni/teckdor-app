<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\FinanceController;
use App\Exports\OrderShippingExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\OrderShippingExportController;

//Login
Route::get('/', [LoginController::class, 'index'])->name('login');
Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'authenticate'])->name('login');
Route::get('/register', [LoginController::class, 'register'])->name('register');
Route::post('/save-register', [LoginController::class, 'saveRegister'])->name('save-register');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');


Route::middleware('auth')->group(function () {

    //Template Halaman
    Route::get('/admin', [DashboardController::class, 'admin'])->name('admin');
    Route::get('/customer', [DashboardController::class, 'customer'])->name('customer');
    Route::get('/finance', [DashboardController::class, 'finance'])->name('finance');

    //Admin
    Route::get('/admin-dashboard', [DashboardController::class, 'adminDashboard'])->name('admin-dashboard');
    Route::get('/customer-dashboard', [DashboardController::class, 'customerDashboard'])->name('customer-dashboard');
    Route::get('/finance-dashboard', [DashboardController::class, 'financeDashboard'])->name('finance-dashboard');

    //Account
    Route::get('/data-users', [UserController::class, 'dataUsers'])->name('data-users');
    Route::get('/add-users', [UserController::class, 'addUsers'])->name('add-users');
    Route::post('/save-users', [UserController::class, 'saveUsers'])->name('save-users');
    Route::get('/data-users/edit/{id}', [UserController::class, 'editUsers'])->name('edit-users');
    Route::post('/data-users/update/{id}', [UserController::class, 'updateUsers'])->name('update-users');
    Route::get('/data-users/delete/{id}', [UserController::class, 'deleteUsers'])->name('delete-users');

    //Supplyer
    Route::get('/data-supplier', [SupplierController::class, 'dataSupplier'])->name('data-supplier');
    Route::post('/save-supplier', [SupplierController::class, 'saveSupplier'])->name('save-supplier');
    Route::get('/data-supplier/edit/{id}', [SupplierController::class, 'editSupplier'])->name('edit-supplier');
    Route::put('/data-supplier/update/', [SupplierController::class, 'updateSupplier'])->name('update-supplier');
    Route::get('/data-supplier/delete/{id}', [SupplierController::class, 'deleteSupplier'])->name('delete-supplier');

    //Category
    Route::get('/data-category', [CategoryController::class, 'dataCategory'])->name('data-category');
    Route::get('/add-category', [CategoryController::class, 'addCategory'])->name('add-category');
    Route::post('/save-category', [CategoryController::class, 'saveCategory'])->name('save-category');
    Route::get('/data-category/edit/{id}', [CategoryController::class, 'editCategory'])->name('edit-category');
    Route::put('/data-category/update/', [CategoryController::class, 'updateCategory'])->name('update-category');
    Route::get('/data-category/delete/{id}', [CategoryController::class, 'deleteCategory'])->name('delete-category');

    //Product
    Route::get('/data-product', [ProductController::class, 'dataProduct'])->name('data-product');
    Route::get('/add-product', [ProductController::class, 'addProduct'])->name('add-product');
    Route::post('/save-product', [ProductController::class, 'saveProduct'])->name('save-product');
    Route::get('/data-product/edit/{id}', [ProductController::class, 'editProduct'])->name('edit-product');
    Route::put('/data-product/update/', [ProductController::class, 'updateProduct'])->name('update-product');
    Route::get('/data-product/delete/{id}', [ProductController::class, 'deleteProduct'])->name('delete-product');
    Route::post('/update_stock', [ProductController::class, 'updateStock'])->name('update-stock');
    Route::post('/update_stock1', [ProductController::class, 'updateStock1'])->name('update-stock1');
    Route::get('/history-stock', [ProductController::class, 'historyStock'])->name('history-stock');
    Route::post('/update-history-stock/{id}', [ProductController::class, 'updateHistoryStock'])->name('update-history-stock');
    Route::get('/delete-history-stock/{id}', [ProductController::class, 'deleteHistoryStock'])->name('delete-history-stock');

    Route::delete('/product/delete-image/{imageId}', [ProductController::class, 'deleteImage'])->name('product.deleteImage');

    //Pesanan
    Route::get('/show-product/{id}', [OrderController::class, 'showProduct'])->name('show-product');
    Route::post('/order-product', [OrderController::class, 'orderProduct'])->name('order-product');
    Route::get('/data-order', [OrderController::class, 'dataOrder'])->name('data-order');
    Route::get('/data-cart', [OrderController::class, 'dataCart'])->name('data-cart');
    Route::get('/edit-cart/{id}', [OrderController::class, 'editCart'])->name('edit-cart');
    Route::post('/orders', [OrderController::class, 'store'])->name('orders-store');
    Route::put('/orders/update', [OrderController::class, 'update'])->name('orders-update');
    Route::get('/cart/delete/{id}', [OrderController::class, 'deleteCart'])->name('delete-cart');
    Route::get('/order/delete/{id}', [OrderController::class, 'deleteOrder'])->name('delete-order');
    Route::post('/save-cart/{id}', [OrderController::class, 'saveCart'])->name('save-cart');

    Route::get('/order-list', [OrderController::class, 'orderList'])->name('order-list');
    Route::post('/order-approve/{id}', [OrderController::class, 'orderApprove'])->name('order-approve');
    Route::get('/order-payment', [OrderController::class, 'orderPayment'])->name('order-payment');
    Route::get('/order-progress', [OrderController::class, 'orderProgress'])->name('order-progress');
    Route::get('/order-log', [OrderController::class, 'orderLog'])->name('order-log');
    Route::get('/order-detail/{code_order}', [OrderController::class, 'orderDetail'])->name('order-detail');
    Route::get('/order-shipping', [OrderController::class, 'orderShipping'])->name('order-shipping');
    Route::post('/search-log', [OrderController::class, 'searchLog'])->name('search-log');

    Route::get('/transaction-list', [FinanceController::class, 'transactionList'])->name('transaction-list');
    Route::get('/transaction-detail/{code_order}', [FinanceController::class, 'transactionDetail'])->name('transaction-detail');
    Route::post('/transaction-payment', [FinanceController::class, 'transactionPayment'])->name('transaction-payment');
    Route::get('/transaction-progress', [FinanceController::class, 'transactionProgress'])->name('transaction-progress');
    Route::delete('/delete-transaction/{id}', [FinanceController::class, 'deleteTransaction'])->name('delete-transaction');
    Route::post('/update-payment-status/{codeOrder}', [OrderController::class, 'updatePaymentStatus']);
    Route::get('/transaction-log', [FinanceController::class, 'transactionLog'])->name('transaction-log');

    Route::get('/order-progress-setting', [OrderController::class, 'orderProgressSetting'])->name('order-progress-setting');
    Route::post('/save-order-progress-setting', [OrderController::class, 'saveOrderProgressSetting'])->name('save-order-progress-setting');
    Route::post('/update-order-progress-setting/{id}', [OrderController::class, 'updateOrderProgressSetting'])->name('update-order-progress-setting');
    Route::get('/delete-order-progress-setting/{id}', [OrderController::class, 'deleteOrderProgressSetting'])->name('delete-order-progress-setting');

    Route::post('/order-progress-update', [OrderController::class, 'orderProgressUpdate'])->name('order-progress-update');
    Route::delete('/order-progress-delete/{id}', [OrderController::class, 'orderProgressDelete'])->name('order-progress-delete');

    Route::get('/payment-supplier-list', [FinanceController::class, 'paymentSupplierList'])->name('payment-supplier-list');
    Route::get('/payment-supplier-detail/{product_id}', [FinanceController::class, 'paymentSupplierDetail'])->name('payment-supplier-detail');
    Route::post('/save-supplier-payment', [FinanceController::class, 'saveSupplierPayment'])->name('save-supplier-payment');
    Route::delete('/delete-supplier-payment/{id}', [FinanceController::class, 'deleteSupplierPayment'])->name('delete-supplier-payment');
    Route::post('/update-supplier-payment-status/{orderId}', [FinanceController::class, 'updateSupplierPaymentStatus'])->name('update-supplier-payment-status');

    Route::post('/order-shipping-update', [OrderController::class, 'orderShippingUpdate'])->name('order-shipping-update');
    Route::get('/order-shipping-detail/{code_shipping}', [OrderController::class, 'orderShippingDetail'])->name('order-shipping-detail');
    Route::get('/order-shipping-delete/{id}', [OrderController::class, 'orderShippingDelete'])->name('order-shipping-delete');
    Route::post('/order-shipping-list-update', [OrderController::class, 'orderShippingListUpdate'])->name('order-shipping-list-update');
    Route::get('/order-shipping-print/{codeShipping}', [OrderController::class, 'orderShippingPrint'])->name('order-shipping-print');

    Route::get('/order-shipping-export/{codeShipping}', [OrderShippingExportController::class, 'exportExcel'])
        ->name('order-shipping-export');

    Route::get('/report-log-export', [OrderShippingExportController::class, 'reportLogExport'])->name('report-log-export');

});
