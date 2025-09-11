<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// //
// Route::post('/register' ,RegisterController::class);
// Route::post('/login', LoginController::class);

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);

Route::prefix('blogs')->group(function () {
    Route::get('/', [App\Http\Controllers\Blog\BlogController::class, 'index']);
    Route::get('/{slug}', [App\Http\Controllers\Blog\BlogController::class, 'show']);
    Route::post('/', [App\Http\Controllers\Blog\BlogController::class, 'store'])->middleware('auth:sanctum');
    Route::put('/{slug}', [App\Http\Controllers\Blog\BlogController::class, 'update'])->middleware('auth:sanctum');
    Route::delete('/{id}', [App\Http\Controllers\Blog\BlogController::class, 'destroy'])->middleware('auth:sanctum');
});
