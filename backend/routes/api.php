<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CaretakerController;
use App\Http\Controllers\RentalExpenseController;
use App\Http\Controllers\RentalController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\TenantController;
use App\Http\Controllers\RentalIncomeController;
use App\Http\Controllers\UserController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/login', [UserController::class, 'login']);
Route::middleware('auth:sanctum')->group(function () {
    Route::delete('/logout', [UserController::class, 'logout']);
    Route::post('/caretaker/create', [CaretakerController::class, 'store']);
    Route::get('/caretakers', [CaretakerController::class, 'index']);
    Route::get('/caretaker/{id}', [CaretakerController::class, 'show']);
    Route::patch('/caretaker/update/{id}', [CaretakerController::class, 'update']);
    Route::delete('/caretaker/delete/{id}', [CaretakerController::class, 'destroy']);
    Route::post('/rentalexpense/create', [RentalExpenseController::class, 'store']);
    Route::get('/rentalexpenses', [RentalExpenseController::class, 'index']);
    Route::get('/rentalexpense/{id}', [RentalExpenseController::class, 'show']);
    Route::patch('/rentalexpense/update/{id}', [RentalExpenseController::class, 'update']);
    Route::delete('/rentalexpense/delete/{id}', [RentalExpenseController::class, 'destroy']);
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
    Route::post('/rentalincome/create', [RentalIncomeController::class, 'store']);
    Route::get('/rentalincomes', [RentalIncomeController::class, 'index']);
    Route::get('/rentalincome/{id}', [RentalIncomeController::class, 'show']);
    Route::patch('/rentalincome/update/{id}', [RentalIncomeController::class, 'update']);
    Route::delete('/rentalincome/delete/{id}', [RentalIncomeController::class, 'destroy']);
    Route::post('/user/create', [UserController::class, 'store']);
    Route::get('/users', [UserController::class, 'index']);
    Route::get('/user/{id}', [UserController::class, 'show']);
    Route::patch('/user/update/{id}', [UserController::class, 'update']);
    Route::delete('/user/delete/{id}', [UserController::class, 'destroy']);
});
?>