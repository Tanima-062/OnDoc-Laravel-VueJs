<?php

use Spatie\PdfToImage\Pdf;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Web\DashboardController;

use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Web\AppUser\AppUserController;
use App\Http\Controllers\Web\Company\CompanyController;
use App\Http\Controllers\Web\Product\ProductController;
use App\Http\Controllers\Web\Category\CategoryController;
use App\Http\Controllers\Web\Supplier\SupplierController;
use App\Http\Controllers\Web\ProfileManagement\UpdatePassword;
use App\Http\Controllers\Web\AppUser\SelfRegistrationController;
use App\Http\Controllers\Web\ChangeLanguage;
use App\Http\Controllers\Web\CompanyAdmin\CompanyAdminController;
use App\Http\Controllers\Web\CompanySubAdmin\CompanySubAdminController;

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

Route::group(['middleware' => ['guest']], function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);


    Route::get('/system-login', [LoginController::class, 'showSystemLoginForm'])->name('system.login');
    Route::post('/system-login', [LoginController::class, 'systemLogin']);

    Route::post('/password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');


    Route::get('/password/request', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::get('password/reset', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('/password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');
    Route::get('/password/reset/success', [ResetPasswordController::class, 'resetSuccess'])->name('password.update.success');

    Route::get('appusers/{appuser}/register', [SelfRegistrationController::class, 'show'])->name('appusers.register');
    Route::put('appusers/{appuser}/register/success', [SelfRegistrationController::class, 'register'])->name('appusers.register.success');
});

Route::group(['middleware' => 'auth'], function () {
    // Route::redirect('/', 'dashboard');
    // Route::redirect('/home', '/dashboard');

    // Route::redirect('/', 'product');
    Route::redirect('/home', '/');

    Route::get('/', DashboardController::class)->name('dashboard');
    Route::put('change-language', ChangeLanguage::class)->name('update.language');

    Route::get('profile-management/update-password', [UpdatePassword::class, 'show'])->name('profile-management.update-password.show');
    Route::put('profile-management/update-password', [UpdatePassword::class, 'update'])->name('profile-management.update-password');

    Route::get('products/filter-data', [ProductController::class, 'getFilterData'])->name('products.filter-data');
    Route::get('products/pdf', [ProductController::class, 'getPdf'])->name('products.getPdf');
    Route::resource('products', ProductController::class);
    Route::put('products/{product}/update-status', [ProductController::class, 'updateStatus'])->name('products.update-status');
    Route::post('products/file-upload', [ProductController::class, 'fileUpload'])->name('products.fileUpload');
    Route::get('products-exports', [ProductController::class, 'export'])->name('products.exports');

    Route::get('appusers/filter-data', [AppUserController::class, 'getFilterData'])->name('appusers.filter-data');


    Route::resource('appusers', AppUserController::class);
    Route::put('appusers/{appuser}/update-status', [AppUserController::class, 'updateStatus'])->name('appusers.update-status');

    Route::get('categories/filter-data', [CategoryController::class, 'getFilterData'])->name('categories.filter-data');
    Route::resource('categories', CategoryController::class)->except('show');
    Route::get('suppliers/filter-data', [SupplierController::class, 'getFilterData'])->name('suppliers.filter-data');
    Route::resource('suppliers', SupplierController::class)->except('show');
    Route::get('companies/filter-data', [CompanyController::class, 'getFilterData'])->name('companies.filter-data');
    Route::resource('companies', CompanyController::class)->except('destroy', 'show');
    Route::delete('companies/{company}/remove-logo', [CompanyController::class, 'deleteLogo'])->name('companies.remove.logo');
    Route::put('companies/{company}/update-status', [CompanyController::class, 'updateStatus'])->name('companies.update-status');
    Route::get('company-admins/filter-data', [CompanyAdminController::class, 'getFilterData'])->name('company-admins.filter-data');
    Route::resource('company-admins', CompanyAdminController::class)->except('show', 'destroy');
    Route::put('company-admins/{company_admin}/toggle-status', [CompanyAdminController::class, 'toggleStatus'])->name('company-admins.toggle-status');

    Route::get('company-sub-admins/filter-data', [CompanySubAdminController::class, 'getFilterData'])->name('company-sub-admins.filter-data');
    Route::resource('company-sub-admins', CompanySubAdminController::class)->except('show', 'destroy');
    Route::put('company-sub-admins/{company_sub_admin}/toggle-status', [CompanySubAdminController::class, 'toggleStatus'])->name('company-sub-admins.toggle-status');

    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

});

