<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WebController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;

/*
|--------------------------------------------------------------------------
| Redirects
|--------------------------------------------------------------------------
*/
Route::get('/' , [WebController::class,  'index'])->name('default');
Route::redirect('/login', '/login');

Route::get('/home', function () {
    return redirect()->route('admin.home');
});

/*
|--------------------------------------------------------------------------
| Auth Routes (Breeze)
|--------------------------------------------------------------------------
*/
require __DIR__ . '/auth.php';

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/
Route::group([
    'prefix' => 'admin',
    'as' => 'admin.',
    'middleware' => ['auth', 'admin'], // admin middleware MUST
], function () {

    // Admin Dashboard
    Route::get('/', [HomeController::class, 'index'])
        ->name('dashboard');
     /* ================= Users ================= */
    Route::resource('users', UserController::class)
        ->middleware('permission:user.view');


    /* ================= Roles ================= */
    Route::resource('roles', RoleController::class)
        ->middleware('permission:role.view');


    /* ================= Permissions ================= */
    Route::delete('permissions/destroy', [PermissionController::class, 'massDestroy'])
        ->middleware('permission:permission.delete')
        ->name('permissions.massDestroy');

    Route::post('permissions/parse-csv-import', [PermissionController::class, 'parseCsvImport'])
        ->middleware('permission:permission.create')
        ->name('permissions.parseCsvImport');

    Route::post('permissions/process-csv-import', [PermissionController::class, 'processCsvImport'])
        ->middleware('permission:permission.create')
        ->name('permissions.processCsvImport');

    Route::resource('permissions', PermissionController::class)
        ->middleware('permission:permission.view');

});

/*
|--------------------------------------------------------------------------
| Profile Routes (Authenticated Users)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
