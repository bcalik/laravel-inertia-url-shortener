<?php

use App\Http\Controllers\AppController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| App Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [AppController::class, 'getIndex']);
Route::get('/links/create', [AppController::class, 'getCreate']);
Route::post('/links/create', [AppController::class, 'postCreate']);
Route::get('/links/edit/{id}', [AppController::class, 'getEdit']);
Route::post('/links/edit/{id}', [AppController::class, 'postEdit']);
Route::delete('/links/delete/{id}', [AppController::class, 'postDelete']);
Route::delete('/links/delete-batch', [AppController::class, 'postDeleteBatch']);
