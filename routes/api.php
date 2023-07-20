<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\LotteryGameController;
use App\Http\Controllers\LotteryGameMatchController;
use App\Http\Controllers\LotteryGameMatchUserController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

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

Route::middleware('guest')->post('/users/register', [UserController::class, 'store']);

Route::group([
    'middleware' => 'api',
], function ($router) {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::post('me', [AuthController::class, 'me']);
});

Route::group([
    'middleware' => 'jwt.auth',
], function ($router) {
    Route::put('/users/{id}', [UserController::class, 'update']);
    Route::delete('/users/{id}', [UserController::class, 'delete']);
    Route::middleware('isAdmin')->get('/users', [UserController::class, 'showAllUsers']);

    Route::middleware('isAdmin')->post('/lottery_game_matches', [LotteryGameMatchController::class, 'store']);
    Route::middleware('isAdmin')->put('/lottery_game_matches/{id}', [LotteryGameMatchController::class, 'update']);

    Route::post('/lottery_game_match_users', [LotteryGameMatchUserController::class, 'store']);
});

Route::get('/lottery_games', [LotteryGameController::class, 'showAll']);
Route::get('/lottery_game_matches', [LotteryGameController::class, 'showById']);
