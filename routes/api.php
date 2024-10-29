<?php

use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/auth/register',[UserController::class,'Register']);

Route::post('/auth/login',[UserController::class,'Login']);
