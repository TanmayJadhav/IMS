<?php

use App\Http\Controllers\ClientController;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\OperatorController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QuotationController;
use App\Http\Controllers\ReasonController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SellProductController;
use App\Http\Controllers\ShopAdminController;
use App\Http\Controllers\VendorController;
use App\Models\Client;
use App\Models\Operator;
use App\Models\Product;
use App\Models\Shop;
use App\Models\Shopadmin;
use App\Models\Shopcategory;
use App\Models\Vendor;

// Route::view('/','pages.login')->name('login');
Route::get('/', [UserController::class, 'getlogin'])->name('login');
Route::post('/', [UserController::class, 'login']);
Route::get('/logout', [UserController::class, 'logout']);


Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'dashboard']);

    // Shop admin routes
    Route::middleware(['admin'])->group(function () {

        // shopadmin routes
        Route::get('/shopadmin', [ShopAdminController::class, 'shopadminlist']);
        Route::get('/shopadmin/add', [ShopAdminController::class, 'get_addshopadmin'])->name('addshopadmin');
        Route::post('/shopadmin/add', [ShopAdminController::class, 'addshopadmin']);
        Route::get('/shopadmin/edit/{shopadmin}', fn (Shopadmin $shopadmin) => view('pages.shopadmin.editshopadmin', ['shopadmin' => $shopadmin]));
        Route::post('/shopadmin/edit/{shopadmin}', [ShopAdminController::class, 'update']);
        Route::post('/shopadmin/{shopadmin}/delete', [ShopAdminController::class, 'delete']);
        Route::post('/shopadmin/{shopadmin}/block', [ShopAdminController::class, 'block']);

        Route::get('/getstatelist/{id}', [ShopAdminController::class, 'getstatelist']);
        Route::get('/getcitylist/{id}', [ShopAdminController::class, 'getcitylist']);

        // Shop category
        Route::view('/shopcategory', 'pages.shopcategory.shopcategory');
        Route::view('/shopcategory/add', 'pages.shopcategory.add');
        Route::post('/shopcategory/add', [ShopAdminController::class, 'add_shopcategory']);
        Route::get('/shopcategory/edit/{shopcategory}', fn (Shopcategory $shopcategory) => view('pages.shopcategory.edit', ['shopcategory' => $shopcategory]));
        Route::post('/shopcategory/edit/{shopcategory}', [ShopAdminController::class, 'edit_shopcategory']);
        Route::post('/shopcategory/{shopcategory}/delete', [ShopAdminController::class, 'shopcategory_delete']);
    });

    Route::middleware(['user'])->group(function () {


        // Vendor Routes
        Route::get('/vendors', [VendorController::class, 'vendorlist']);
        Route::view('/vendors/add', 'pages.vendors.add');
        Route::post('/vendors/add', [VendorController::class, 'addvendor']);
        // Route::get('/vendors/addproductcategory', [VendorController::class, 'get_addproductcategory_page']);
        // Route::post('/vendors/addproductcategory', [VendorController::class, 'addproductcategory']);
        Route::get('/vendors/edit/{vendors}', fn (Vendor $vendors) => view('pages.vendors.edit', ['vendors' => $vendors]));
        Route::post('/vendors/edit/{vendors}', [VendorController::class, 'update']);
        Route::post('/vendors/{vendors}/delete', [VendorController::class, 'delete']);
        Route::post('/vendors/productcategory/{productcategory}/delete', [VendorController::class, 'delete_productcategory']);
        Route::post('/add_category/{name}', [VendorController::class, 'addproductcategory']);


        // Product Routes
        Route::get('/product', [ProductController::class, 'productlist']);
        Route::get('/product/add', [ProductController::class, 'get_addproduct']);
        Route::post('/product/add', [ProductController::class, 'addproduct']);
        Route::get('/product/edit/{product}', [ProductController::class, 'get_productedit']);
        Route::post('/product/edit/{product}', [ProductController::class, 'update_product']);
        Route::post('/product/{product}/delete', [ProductController::class, 'delete']);
        Route::post('/addcategory/{name}', [ProductController::class, 'add_category']);
        Route::get('/info', [ProductController::class, 'get_info']);
        Route::post('file-import', [ProductController::class, 'fileImport'])->name('file-import');

        // Clients Routes
        Route::get('/client', [ClientController::class, 'clientlist']);
        Route::view('/client/add', 'pages.clients.add');
        Route::post('/client/add', [ClientController::class, 'addclient']);
        Route::get('/client/edit/{client}', fn (Client $client) => view('pages.clients.edit', ['client' => $client]));
        Route::post('/client/edit/{client}', [ClientController::class, 'update_client']);
        Route::get('/client/view/{client}', [ClientController::class, 'view_client']);
        Route::post('/client/{client}/delete', [ClientController::class, 'delete']);
        Route::post('/payment', [ClientController::class, 'make_payment']);
        Route::get('/paymentdetails/{client_id}', [ClientController::class, 'payment_details']);


        // Quotation Routes
        Route::get('/quotation', [QuotationController::class, 'get_quotation_list']);
        Route::get('/quotation/add', [QuotationController::class, 'get_quotation_add_page']);
        Route::post('/quotation/add', [QuotationController::class, 'add_quotation']);
        Route::post('/quotation/sessionadd', [QuotationController::class, 'session_add']);
        Route::post('/session_product/{session}/delete', [QuotationController::class, 'delete']);
        Route::get('/quotation/{quotation}/view', [QuotationController::class, 'view_pdf']);
        Route::get('/quotation/{quotation}/pdfdownload', [QuotationController::class, 'download_pdf']);
        Route::post('/quotation/{quotation}/delete', [QuotationController::class, 'quotation_delete']);

        // Sell Products
        Route::get('/sellproduct', [SellProductController::class, 'get_sellproduct_list']);
        Route::get('/sellproduct/add', [SellProductController::class, 'get_sellproduct_add_page']);
        Route::post('/sellproduct/add', [SellProductController::class, 'post_sellproduct_add_page']);
        Route::get('/sellproduct/add_customer_details', [SellProductController::class, 'add_customer_detail']);
        Route::post('/sellproduct/add_customer_details', [SellProductController::class, 'postAddCustomerDetails']);
        Route::post('/sellproduct/add', [SellProductController::class, 'add_sellproduct']);
        Route::post('/sellproduct/sessionadd', [SellProductController::class, 'session_add']);
        Route::post('/session_product/{session}/delete', [SellProductController::class, 'delete']);
        Route::get('/sellproduct/{sellproduct}/view', [SellProductController::class, 'view_pdf']);
        Route::get('/sellproduct/{sellproduct}/pdfdownload', [SellProductController::class, 'download_pdf']);
        Route::post('/receipt/{receipt}/delete', [SellProductController::class, 'receipt_delete']);
        Route::post('/addcustomer/{name}/{mobile}/{address}', [SellProductController::class, 'addCustomer']);
        Route::post('/addreferal/{name}', [SellProductController::class, 'add_referal']);


        // Profile Routes
        Route::get('/profile/{id}', [ProfileController::class, 'get_profile_page']);
        Route::post('/profile/edit/{id}', [ProfileController::class, 'edit_profile']);
        Route::post('/profile/image/{id}', [ProfileController::class, 'profile_image']);


        // Reports Route
        Route::get('/report', [ReportController::class, 'get_report_page']);
        Route::post('/report/filter', [ReportController::class, 'filter_report']);

        // Operators Route
        Route::get('/operator', [OperatorController::class, 'get_operator_list']);
        Route::get('/operator/add', [OperatorController::class, 'get_operator_add']);
        Route::post('/operator/add', [OperatorController::class, 'operator_add']);
        Route::get('/operator/edit/{operator}', fn (Operator $operator) => view('pages.operators.edit', ['operator' => $operator]));
        Route::post('/operator/edit/{operator}', [OperatorController::class, 'update_operator']);
        Route::post('/operator/{operator}/delete', [OperatorController::class, 'delete']);

        // Expense Routes
        Route::get('/expense', [ExpenseController::class, 'getListExpense']);
        Route::get('/expense/add', [ExpenseController::class, 'getCreateExpense']);
        Route::post('/expense/add', [ExpenseController::class, 'postCreateExpense']);
        Route::get('/expense/edit/{expenseId}', [ExpenseController::class, 'getEditExpense']);
        Route::post('/expense/edit/{expenseId}', [ExpenseController::class, 'postEditExpense']);
        Route::get('/expense/delete/{expenseId}', [ExpenseController::class, 'deleteExpense']);
        Route::get('/expense/filter', [ExpenseController::class, 'filterExpense']);

        // Reason Routes
        Route::get('/reason', [ReasonController::class, 'getListReason']);
        Route::get('/reason/add', [ReasonController::class, 'getCreateReason']);
        Route::post('/reason/add', [ReasonController::class, 'postCreateReason']);
        Route::get('/reason/edit/{reasonId}', [ReasonController::class, 'getEditReason']);
        Route::post('/reason/edit/{reasonId}', [ReasonController::class, 'postEditReason']);
        Route::get('/reason/delete/{reasonId}', [ReasonController::class, 'deleteReason']);


        // Employee Routes

        Route::get('/employee', [EmployeeController::class, 'getListEmployee']);
        Route::view('/employee/add', 'pages.employee.add');
        Route::post('/employee/add', [EmployeeController::class, 'postCreateEmployee']);
        Route::get('/employee/edit/{employeeId}', [EmployeeController::class, 'getEditEmployee']);
        Route::post('/employee/edit/{employeeId}', [EmployeeController::class, 'postEditEmployee']);
        Route::get('/employee/delete/{employeeId}', [EmployeeController::class, 'deleteEmployee']);
        Route::get('/add-monthly-salary', [EmployeeController::class, 'addMonthlySalary']);
        Route::post('/employee/makepayment/{id}', [EmployeeController::class, 'makePaymentEmployee']);
        Route::get('/employee/paymentdetails/{id}', [EmployeeController::class, 'paymentDetailsEmployee']);


        // Current Category Routes
        Route::get('/set-category/{category}',[Controller::class,'setCurrentCategory']);
    });
});

// Route::get('/', function () {
//     return view('pages.dashboard');
// });
