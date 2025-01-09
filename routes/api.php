<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DivisionController;


Route::post('/login', [LoginController::class, 'login'])->name('login');

Route::get('/divisions', [DivisionController::class, 'index'])->name('divisions.index');

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
