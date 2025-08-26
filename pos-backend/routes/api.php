<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::apiResource('users', App\Http\Controllers\Api\UserController::class);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Public routes
Route::post('/login', [App\Http\Controllers\Api\AuthController::class, 'login']);
Route::post('/logout', [App\Http\Controllers\Api\AuthController::class, 'logout']);

// Business Locations (public for registration)
Route::get('business-locations/active', [App\Http\Controllers\Api\BusinessLocationController::class, 'active']);

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    // User roles and permissions
    Route::apiResource('user-roles', App\Http\Controllers\Api\UserRoleController::class);
    Route::post('user-roles/{userRole}/permissions', [App\Http\Controllers\Api\UserRoleController::class, 'assignPermissions']);
    
    // Permissions
    Route::get('permissions/tabs', [App\Http\Controllers\Api\PermissionController::class, 'tabs']);
    Route::get('permissions/types', [App\Http\Controllers\Api\PermissionController::class, 'types']);
    Route::get('permissions/tab-permissions', [App\Http\Controllers\Api\PermissionController::class, 'tabPermissions']);
    Route::post('permissions/tabs', [App\Http\Controllers\Api\PermissionController::class, 'storeTab']);
    Route::post('permissions/types', [App\Http\Controllers\Api\PermissionController::class, 'storeType']);
    Route::post('permissions/tab-permissions', [App\Http\Controllers\Api\PermissionController::class, 'storeTabPermission']);
    
    // Users
    Route::get('users/for-commission', [App\Http\Controllers\Api\UserController::class, 'getUsersForCommission']);
    
    // Business Locations (protected for management)
    Route::apiResource('business-locations', App\Http\Controllers\Api\BusinessLocationController::class);
    
    // Suppliers
    Route::apiResource('suppliers', App\Http\Controllers\Api\SupplierController::class);
    Route::get('suppliers/active', [App\Http\Controllers\Api\SupplierController::class, 'active']);
    Route::get('suppliers/with-dues', [App\Http\Controllers\Api\SupplierController::class, 'withDues']);
    Route::get('suppliers/{supplier}/dues', [App\Http\Controllers\Api\SupplierController::class, 'getDues']);
    Route::post('suppliers/{supplier}/dues', [App\Http\Controllers\Api\SupplierController::class, 'updateDues']);
}); 