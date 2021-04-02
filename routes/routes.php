<?php

use Illuminate\Support\Facades\Route;
use Thotam\ThotamPermission\Http\Controllers\RoleController;

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

Route::middleware(['web', 'auth', 'CheckAccount'])->group(function () {

    //Route Admin
    Route::redirect('admin', '/', 301);
    Route::group(['prefix' => 'admin'], function () {

        //Route quản lý Role và Quyền
        Route::redirect('permission', '/', 301);
        Route::group(['prefix' => 'permission'], function () {

            Route::get('role',  [RoleController::class, 'index'])->name('admin.permission.role');
        });

    });

});
