<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CaretakerController;
use App\Http\Controllers\OwnerController;
use App\Http\Controllers\OwnerExpenseController;
use App\Http\Controllers\RentalController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\TenantController;
use App\Http\Controllers\TenantExpenseController;
use App\Http\Controllers\UserController;

Route::middleware('auth:sanctum')->get('/user', function(Request $request) {
    return $request->user();
});

Route::post('/login', [UserController::class, 'login']);
Route::middleware('auth:sanctum')->group(function () {
    Route::delete('/logout', [UserController::class, 'logout']);
    Route::post('/caretaker/create', [CaretakerController::class, 'store']);
    Route::get('/caretakers', [CaretakerController::class, 'index']);
    Route::get('/caretaker/{id}', [CaretakerController::class, 'show']);
    Route::patch('/caretaker/update/{id}', [CaretakerController::class, 'update']);
    Route::delete('/caretaker/delete/{id}', [CaretakerController::class, 'destroy']);
    Route::post('/owner/create', [OwnerController::class, 'store']);
    Route::get('/owners', [OwnerController::class, 'index']);
    Route::get('/owner/{id}', [OwnerController::class, 'show']);
    Route::patch('/owner/update/{id}', [OwnerController::class, 'update']);
    Route::delete('/owner/delete/{id}', [OwnerController::class, 'destroy']);
    Route::post('/ownerexpense/create', [OwnerExpenseController::class, 'store']);
    Route::get('/ownerexpenses', [OwnerExpenseController::class, 'index']);
    Route::get('/ownerexpense/{id}', [OwnerExpenseController::class, 'show']);
    Route::patch('/ownerexpense/update/{id}', [OwnerExpenseController::class, 'update']);
    Route::delete('/ownerexpense/delete/{id}', [OwnerExpenseController::class, 'destroy']);
    Route::post('/rental/create', [RentalController::class, 'store']);
    Route::get('/rentals', [RentalController::class, 'index']);
    Route::get('/rental/{id}', [RentalController::class, 'show']);
    Route::patch('/rental/update/{id}', [RentalController::class, 'update']);
    Route::delete('/rental/delete/{id}', [RentalController::class, 'destroy']);
    Route::post('/room/create', [RoomController::class, 'store']);
    Route::get('/rooms', [RoomController::class, 'index']);
    Route::get('/room/{id}', [RoomController::class, 'show']);
    Route::patch('/room/update/{id}', [RoomController::class, 'update']);
    Route::delete('/room/delete/{id}', [RoomController::class, 'destroy']);
    Route::post('/tenant/create', [TenantController::class, 'store']);
    Route::get('/tenants', [TenantController::class, 'index']);
    Route::get('/tenant/{id}', [TenantController::class, 'show']);
    Route::patch('/tenant/update/{id}', [TenantController::class, 'update']);
    Route::delete('/tenant/delete/{id}', [TenantController::class, 'destroy']);
    Route::post('/tenantexpense/create', [TenantExpenseController::class, 'store']);
    Route::get('/tenantexpenses', [TenantExpenseController::class, 'index']);
    Route::get('/tenantexpense/{id}', [TenantExpenseController::class, 'show']);
    Route::patch('/tenantexpense/update/{id}', [TenantExpenseController::class, 'update']);
    Route::delete('/tenantexpense/delete/{id}', [TenantExpenseController::class, 'destroy']);
    Route::post('/user/create', [UserController::class, 'store']);
    Route::get('/users', [UserController::class, 'index']);
    Route::get('/user/{id}', [UserController::class, 'show']);
    Route::patch('/user/update/{id}', [UserController::class, 'update']);
    Route::delete('/user/delete/{id}', [UserController::class, 'destroy']);
});
?>