<?php

use App\Http\Controllers\Api\AdminBootstrapController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BrandingController;
use App\Http\Controllers\Api\BrandingAdminController;
use App\Http\Controllers\Api\CalificacionesImportController;
use App\Http\Controllers\Api\NotasController;
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

Route::get('/test-db-laravel', function () {
    try {
        \Illuminate\Support\Facades\DB::connection()->getPdo();
        return response()->json([
            'status' => 'success',
            'message' => 'Conexion a la base de datos a traves de Laravel establecida con exito.',
            'database' => \Illuminate\Support\Facades\DB::connection()->getDatabaseName(),
            'tables' => array_map('current', \Illuminate\Support\Facades\DB::select('SHOW TABLES')),
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => 'Fallo la conexion a la base de datos desde Laravel.',
            'error' => $e->getMessage(),
        ], 500);
    }
});

Route::get('/branding-assets/{fileName}', [BrandingController::class, 'asset'])
    ->where('fileName', '[A-Za-z0-9\-_.]+');

Route::prefix('api')->group(function () {
    Route::get('/branding', [BrandingController::class, 'show']);
    Route::post('/auth/login', [AuthController::class, 'login']);
    Route::post('/auth/logout', [AuthController::class, 'logout']);
    Route::get('/auth/me', [AuthController::class, 'me']);

    Route::middleware('auth')->group(function () {
        Route::post('/auth/change-password', [AuthController::class, 'changePassword']);
        Route::get('/navigation', [NavigationController::class, 'navigation']);
        Route::get('/modules/{moduleSlug}/{viewSlug}', [NavigationController::class, 'show']);
        Route::get('/calificaciones/importacion/summary', [CalificacionesImportController::class, 'summary']);
        Route::post('/calificaciones/importacion/preview', [CalificacionesImportController::class, 'preview']);
        Route::get('/calificaciones/importacion/preview/{token}/invalid-csv', [CalificacionesImportController::class, 'downloadInvalidCsv']);
        Route::post('/calificaciones/importacion/upload', [CalificacionesImportController::class, 'store']);
        Route::get('/notas', [NotasController::class, 'index']);
        Route::put('/notas/{notaId}', [NotasController::class, 'update']);
        Route::delete('/notas/{notaId}', [NotasController::class, 'destroy']);

        Route::prefix('/admin')->group(function () {
            Route::get('/bootstrap', [AdminBootstrapController::class, 'index']);

            Route::get('/users', [UserAdminController::class, 'index']);
            Route::post('/users', [UserAdminController::class, 'store']);
            Route::post('/users/reset-student-passwords', [UserAdminController::class, 'resetStudentPasswords']);
            Route::post('/users/{user}/reset-password', [UserAdminController::class, 'resetPassword']);
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

            Route::get('/branding', [BrandingAdminController::class, 'show']);
            Route::post('/branding', [BrandingAdminController::class, 'update']);
        });
    });
});
