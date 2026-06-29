<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;

Route::get('/', function () {
    return "Phu Xuan Events chạy OK 🚀";
});

Route::get('/events', [EventController::class, 'index']);