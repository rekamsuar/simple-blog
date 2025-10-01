<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PageController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::middleware('auth:sanctum')->get('user', [AuthController::class, 'index']);
    Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);
    Route::middleware('auth:sanctum')->get('/check-user', function (Request $request) {
        return $request->user();
    });
});

Route::prefix('blogs')->group(function () {
    Route::get('/', [BlogController::class, 'index']);
    Route::get('/{slug}', [BlogController::class, 'show']);
    Route::post('/', [BlogController::class, 'store'])->middleware('auth:sanctum');
    Route::patch('/{slug}', [BlogController::class, 'update'])->middleware('auth:sanctum');
    Route::delete('/{slug}', [BlogController::class, 'destroy'])->middleware('auth:sanctum');
});

Route::prefix('categories')->group(function () {
    Route::get('/', [CategoryController::class, 'index']);
    Route::get('/{id}', [CategoryController::class, 'show']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/', [CategoryController::class, 'store']);
        Route::put('/{id}', [CategoryController::class, 'update']);
        Route::delete('/{id}', [CategoryController::class, 'destroy']);
    });
});

Route::prefix('pages')->group(function () {
    Route::get('/', [PageController::class, 'index']);
    Route::get('/{slug}', [PageController::class, 'show']);
    Route::post('/', [PageController::class, 'store'])->middleware('auth:sanctum');
    Route::patch('/{slug}', [PageController::class, 'update'])->middleware('auth:sanctum');
    Route::delete('/{slug}', [PageController::class, 'destroy'])->middleware('auth:sanctum');

    Route::post('/{slug}/view', [PageController::class, 'addView']);
});
