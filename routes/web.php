<?php

use App\Http\Controllers\MainController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Prefer Laravel 4.2 style controller methods here, prefixed with the HTTP verb they respond to.
Route::get('/health', [MainController::class, 'getHealth']);
Route::get('/{slug}', [MainController::class, 'getSlug']);
Route::get('/', [MainController::class, 'getIndex']);

// See the routes/app.php file for the rest of the routes.
