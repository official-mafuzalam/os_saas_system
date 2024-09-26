<?php

declare(strict_types=1);

use App\Http\Controllers\app\HomeController;
use App\Http\Controllers\app\PermissionController;
use App\Http\Controllers\app\ProfileController;
use App\Http\Controllers\app\RoleController;
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
        return to_route('tenant.dashboard');
    });




    Route::middleware('auth')->prefix('/dashboard')->group(function () {

        // Dashboard route
        Route::get('/', [HomeController::class,'index'])->name('tenant.dashboard');





        // Roles

        Route::get('/role', [RoleController::class, 'role'])->name('tenant.role');

        Route::get('/role/create', [RoleController::class, 'roleCreatePage'])->name('tenant.role.createPage');

        Route::post('/role/create', [RoleController::class, 'create'])->name('tenant.role.create');

        Route::get('/role/edit/{id}', [RoleController::class, 'roleEditPage'])->name('tenant.role.edit');

        Route::put('/role/update/{id}', [RoleController::class, 'roleUpdate'])->name('tenant.role.update');

        Route::post('/roles/{role}/permissions', [RoleController::class, 'givePermission'])->name('tenant.role.permissions');

        Route::delete('/roles/{role}/permissions/{permission}', [RoleController::class, 'revokePermission'])->name('tenant.role.permissions.revoke');



        // Permissions

        Route::get('/permission', [PermissionController::class, 'permission'])->name('tenant.permission');

        Route::get('/permission/create', [PermissionController::class, 'permissionCreatePage'])->name('tenant.permission.createPage');

        Route::post('/permission/create', [PermissionController::class, 'permissionCreate'])->name('tenant.permission.create');

        Route::get('/permission/edit/{id}', [PermissionController::class, 'permissionEditPage'])->name('tenant.permission.edit');

        Route::put('/permission/update/{id}', [PermissionController::class, 'permissionUpdate'])->name('tenant.permission.update');

        Route::post('/permissions/{permission}/roles', [PermissionController::class, 'givePermission'])->name('tenant.permissions.role');

        Route::delete('/permissions/{permission}/roles/{role}', [PermissionController::class, 'removeRole'])->name('tenant.permissions.roles.revoke');


        // Users

        Route::get('/users', [UserController::class, 'index'])->name('tenant.user');

        Route::get('/user/create', [UserController::class, 'create'])->name('tenant.user.createPage');

        Route::post('/user/create', [UserController::class, 'store'])->name('tenant.user.create');


        Route::get('/users/{user}', [UserController::class, 'show'])->name('tenant.users.show');

        Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('tenant.users.destroy');

        Route::post('/users/{user}/roles', [UserController::class, 'assignRole'])->name('tenant.users.roles');

        Route::delete('/users/{user}/roles/{role}', [UserController::class, 'removeRole'])->name('tenant.users.roles.remove');

        Route::post('/users/{user}/permissions', [UserController::class, 'givePermission'])->name('tenant.users.permissions');

        Route::delete('/users/{user}/permissions/{permission}', [UserController::class, 'revokePermission'])->name('tenant.users.permissions.revoke');

        Route::get('/check-permissions', [PermissionController::class, 'checkPer']);






















        Route::get('/profile', [ProfileController::class, 'edit'])->name('tenant.profile.edit');

        Route::patch('/profile', [ProfileController::class, 'update'])->name('tenant.profile.update');

        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('tenant.profile.destroy');

    });

    require __DIR__ . '/tenant-auth.php';



});
