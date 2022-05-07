<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::post('upazila-list', [HomeController::class, 'upazilaList'])->name('upazila.list');

Route::resource('users', UserController::class);

Route::prefix('user')->group(function () {
    Route::name('user.')->group(function () {
        Route::post('store', [UserController::class, 'store'])->name('store');
        Route::post('list', [UserController::class, 'userList'])->name('list');
        Route::post('edit', [UserController::class, 'edit'])->name('edit');
        Route::post('show', [UserController::class, 'show'])->name('show');
        Route::post('destroy', [UserController::class, 'destroy'])->name('destroy');
        Route::post('change-status', [UserController::class, 'changeStatus'])->name('change.status');
        Route::post('bulk-action-delete', [UserController::class, 'bulkActionDelete'])->name('bulk.action.delete');
    });
});


