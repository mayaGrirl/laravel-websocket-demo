<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Broadcast;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PushController;
use Illuminate\Http\Request;


Route::post('/login', [AuthController::class, 'login']);


// /broadcasting/auth 需要使用 auth:sanctum 来验证 Bearer token
Route::post('/broadcasting/auth', function (Request $request) {
    return Broadcast::auth($request);
})->middleware('auth:sanctum');


Route::post('/push', [PushController::class, 'send'])->middleware('auth:sanctum');
