<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CheckController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
//list check
Route::get('/check_list/{pg?}', [CheckController::class, 'check_list']);
Route::get('/search_check_list/{pg?}', [CheckController::class, 'search_check_list']);
Route::put('/update_check_list/{pg?}', [CheckController::class, 'update_check_list']);
Route::get('/detail_check_list/{id}', [CheckController::class, 'detail_check_list']);
// admin list checked
Route::get('/checked_list/{pg?}', [CheckController::class, 'checked_list']);
Route::get('/search_checked_list/{pg?}', [CheckController::class, 'search_checked_list']);
Route::put('/update_checked_list/{pg?}', [CheckController::class, 'update_checked_list']);
Route::get('/detail_checked_list/{id}', [CheckController::class, 'detail_checked_list']);
Route::post('/register_list', [CheckController::class, 'register_list']);
// Route::get('/list/{pg?}',[ListController::class,'list']);