<?php

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

# Membuat authentication group
Route::middleware(['auth:sanctum'])->group(function(){
    # Get All Resource / Memanggil semua data menggunakan get
    Route::get('/news', [NewsController::class, 'index']);

    # Add Resource / Menambah data news menggunakan post
    Route::post('/news', [NewsController::class, 'store']);

    # Get Detail Resource / Menampilkan detail data news menggunakan get
    Route::get('/news/{id}', [NewsController::class, 'show']);

    # Edit Resource / Mengedit data news menggunakan put
    Route::put('/news/{id}', [NewsController::class, 'update']);

    # Delete Resource / Menghapus data news menggunakan delete
    Route::delete('/news/{id}', [NewsController::class, 'destroy']);

    # Search Resource by title / Mencari data news-title menggunakan get
    Route::get('/news/search/{title}', [NewsController::class, 'search']);

    # Get Sport Resource / Menampikan data news-cat-sport menggunakan get
    Route::get('/news/category/sport', [NewsController::class, 'sport']);

    # Get Finance Resource / Menampilkan data news-cat-finance menggunakan get
    Route::get('/news/category/finance', [NewsController::class, 'finance']);

    # Get Automotive Resource / Menampikan data news-cat-automotive menggunakan get
    Route::get('/news/category/automotive', [NewsController::class, 'automotive']);
});
