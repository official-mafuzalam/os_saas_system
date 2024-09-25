<?php

declare(strict_types=1);

use App\Http\Controllers\app\ProfileController;
use App\Http\Controllers\app\UserController;
use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;

/*
|--------------------------------------------------------------------------
| Tenant Routes
|--------------------------------------------------------------------------
|
| Here you can register the tenant routes for your application.
| These routes are loaded by the TenantRouteServiceProvider.
|
| Feel free to customize them however you want. Good luck!
|
*/

Route::middleware([
    'web',
    InitializeTenancyByDomain::class,
    PreventAccessFromCentralDomains::class,
])->group(function () {
    Route::get('/', function () {
        return view('app.index');
    });




    Route::middleware('auth')->group(function () {

        Route::get('/dashboard', function () {
            return view('app.index');
        });



        Route::get('/users', [UserController::class, 'index'])->name('tenant.user');

        Route::get('/user/create', [UserController::class, 'create'])->name('tenant.user.createPage');

        Route::post('/user/create', [UserController::class, 'store'])->name('tenant.user.create');



        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');

        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');

        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    });

    require __DIR__ . '/tenant-auth.php';



});
