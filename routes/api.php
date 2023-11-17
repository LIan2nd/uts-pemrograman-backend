<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\NewsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Route Group untuk Middleware
Route::middleware(['auth:sanctum'])->group(function () {
    // Route Resource yang sudah mencakup keseluruhan method untuk resource
    // Route::resource('/news', NewsController::class)->except('create', 'edit');

    // Route CRUD News
    Route::get('/news', [NewsController::class, 'index']);
    Route::post('/news', [NewsController::class, 'store']);
    Route::get('/news/{id}', [NewsController::class, 'show']);
    Route::put('/news/{id}', [NewsController::class, 'update']);
    Route::delete('/news/{id}', [NewsController::class, 'destroy']);

    // Route untuk method yang tidak ada di route resource
    Route::get('/news/search/{title}', [NewsController::class, 'search']);
    Route::get('/news/category/sport', [NewsController::class, 'sport']);
    Route::get('/news/category/finance', [NewsController::class, 'finance']);
    Route::get('/news/category/automotive', [NewsController::class, 'automotive']);
});


// Route untuk Otentikasi
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
