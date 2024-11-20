<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TaskController;

Route::prefix('user')->name('user.')->group(function () {
    Route::post('login', [AuthController::class, 'login'])->name('login');
    Route::post('register', [AuthController::class, 'register'])->name('register');
    Route::post('logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth:sanctum');
    Route::get('verify', [AuthController::class, 'verify'])->name('verify')->middleware('auth:sanctum');
});

Route::prefix('task')->middleware('auth:sanctum')->name('user.')->group(function () {
    Route::get('/', [TaskController::class, 'index'])->name('index');
    Route::get('{id}', [TaskController::class, 'show'])->name('show');
    Route::post('/', [TaskController::class, 'store'])->name('store');
    Route::put('{id}', [TaskController::class, 'update'])->name('update');
    Route::delete('{id}', [TaskController::class, 'destroy'])->name('destroy');
});