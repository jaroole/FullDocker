<?php


use App\Http\Controllers\BotController;

use Illuminate\Support\Facades\Route;



Route::post('/bot', [BotController::class, 'index']);
