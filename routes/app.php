<?php

use App\Http\Controllers\LinkController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| App Routes
|--------------------------------------------------------------------------
*/

// Prefer Laravel 4.2 style controller methods here, prefixed with the HTTP verb they respond to.
Route::get('/', [LinkController::class, 'getIndex']);
Route::get('/links/create', [LinkController::class, 'getCreate']);
Route::post('/links/create', [LinkController::class, 'postCreate']);
Route::get('/links/edit/{link}', [LinkController::class, 'getEdit']);
Route::post('/links/edit/{link}', [LinkController::class, 'postEdit']);
Route::delete('/links/delete/{link}', [LinkController::class, 'postDelete']);
Route::delete('/links/delete-batch', [LinkController::class, 'postDeleteBatch']);
