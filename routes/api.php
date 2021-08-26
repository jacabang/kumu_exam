<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestController;
use App\Http\Controllers\PageController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('/fetchUser', [TestController::class, 'fetchUser'])
	->middleware('auth:api');

Route::post('/hmd', [PageController::class, 'hmd']);
Route::post('/unauthorize', [PageController::class, 'unauthorize'])->name('login');
Route::post('/register', [PageController::class, 'register']);
Route::post('/login', [PageController::class, 'login']);
Route::post('/logout', [TestController::class, 'logout'])
	->middleware('auth:api');
