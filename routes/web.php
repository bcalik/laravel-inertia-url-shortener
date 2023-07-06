<?php

use App\Http\Controllers\LinkController;
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

Route::get('/health', function () {
    $headers = ['ip' => request()->ip(), 'ips' => request()->ips()] + request()->header();
    return response()->json($headers);
});

Route::get('/{slug}', [LinkController::class, 'getSlug']);

Route::get('/', function () {
    return redirect('default');
});

// See the routes/app.php file for the rest of the routes.
