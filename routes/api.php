<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DivisionController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\NilaiController;

Route::middleware('guest')->group(function () {
    Route::post('/login', [LoginController::class, 'login'])->name('login');
});

Route::get('/nilaiRT', [NilaiController::class, 'getNilaiRT']);
Route::get('/nilaiST', [NilaiController::class, 'getNilaiST']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/divisions', [DivisionController::class, 'index'])->name('divisions.index');
    Route::apiResource('employees', EmployeeController::class);
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
});

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
