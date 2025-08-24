<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AppController;
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

Route::get('home-data',[AppController::class,'homeData']);
Route::POST('search-open-file',[AppController::class,'search-open-File']);
Route::POST('submit-form',[AppController::class,'customer_query']);
Route::POST('search-closed-file',[AppController::class,'closed_files'])->name('closed-file');

