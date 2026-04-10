<?php

use App\Http\Controllers\Api\AdminBootstrapController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\NavigationController;
use App\Http\Controllers\Api\PermissionAdminController;
use App\Http\Controllers\Api\RoleAdminController;
use App\Http\Controllers\Api\ModuleAdminController;
use App\Http\Controllers\Api\UserAdminController;
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

Route::get('/', function () {
    return response()->json([
        'app' => 'UMLA API',
        'status' => 'ok',
    ]);
});

Route::prefix('api')->group(function () {
    Route::post('/auth/login', [AuthController::class, 'login']);
    Route::post('/auth/logout', [AuthController::class, 'logout']);
    Route::get('/auth/me', [AuthController::class, 'me']);

    Route::middleware('auth')->group(function () {
        Route::get('/navigation', [NavigationController::class, 'navigation']);
        Route::get('/modules/{moduleSlug}/{viewSlug}', [NavigationController::class, 'show']);

        Route::prefix('/admin')->group(function () {
            Route::get('/bootstrap', [AdminBootstrapController::class, 'index']);

            Route::get('/users', [UserAdminController::class, 'index']);
            Route::post('/users', [UserAdminController::class, 'store']);
            Route::put('/users/{user}', [UserAdminController::class, 'update']);
            Route::delete('/users/{user}', [UserAdminController::class, 'destroy']);

            Route::get('/roles', [RoleAdminController::class, 'index']);
            Route::post('/roles', [RoleAdminController::class, 'store']);
            Route::put('/roles/{role}', [RoleAdminController::class, 'update']);
            Route::delete('/roles/{role}', [RoleAdminController::class, 'destroy']);
            Route::put('/roles/{role}/access', [RoleAdminController::class, 'syncAccess']);

            Route::get('/modules', [ModuleAdminController::class, 'index']);
            Route::post('/modules', [ModuleAdminController::class, 'store']);
            Route::put('/modules/{module}', [ModuleAdminController::class, 'update']);
            Route::delete('/modules/{module}', [ModuleAdminController::class, 'destroy']);
            Route::post('/modules/{module}/views', [ModuleAdminController::class, 'storeView']);
            Route::put('/module-views/{moduleView}', [ModuleAdminController::class, 'updateView']);
            Route::delete('/module-views/{moduleView}', [ModuleAdminController::class, 'destroyView']);

            Route::get('/permissions', [PermissionAdminController::class, 'index']);
            Route::post('/permissions', [PermissionAdminController::class, 'store']);
            Route::put('/permissions/{permission}', [PermissionAdminController::class, 'update']);
            Route::delete('/permissions/{permission}', [PermissionAdminController::class, 'destroy']);
        });
    });
});
