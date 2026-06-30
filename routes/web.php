<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application.
|
*/

// Trang chủ -> chuyển sang danh sách sự kiện
Route::redirect('/', '/events');

// Danh sách sự kiện
Route::get('/events', [EventController::class, 'index']);