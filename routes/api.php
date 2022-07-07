<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EquipmentController;
use App\Http\Controllers\EquipmentTypeController;
use App\Http\Controllers\Auth\{
    LoginController, 
    LogoutController, 
    RegisterController
};

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

/*Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});*/

Route::middleware('cors')->group( function () {
    Route::post('register', [RegisterController::class, 'register']);
    Route::post('login', [LoginController::class, 'login']);
});

Route::group(['middleware' => ['cors', 'auth:api']], function () {
    Route::apiResource('equipment', EquipmentController::class);
    Route::get('equipment-type', [EquipmentTypeController::class, 'index']);
    Route::get('logout', [LogoutController::class, 'logout']);
});

/*Route::middleware('auth:api')->group( function () {
    Route::apiResource('equipment', EquipmentController::class);
    //Route::get('logout', [LogoutController::class, 'logout']);
});*/
