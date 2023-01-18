<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\LotteryGameController;
use App\Http\Controllers\LotteryGameMatchController;
use App\Http\Controllers\LotteryGameMatchUserController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
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

Route::middleware('jwt.auth')->put('/users/{id}', [UserController::class, 'update']);

Route::middleware('jwt.auth')->delete('/users/{id}', [UserController::class, 'delete']);

Route::get('/lottery_games', [LotteryGameController::class, 'showAll']);

//admin
Route::middleware('jwt.auth')->post('/lottery_game_matchs', [LotteryGameMatchController::class, 'store']);

//admin
Route::middleware('jwt.auth')->put('/lottery_game_matchs', [LotteryGameMatchController::class, 'update']);


Route::middleware('jwt.auth')->post('/lottery_game_match_users', [LotteryGameMatchUserController::class, 'store']);

Route::get('/lottery_game_matchs', [LotteryGameController::class, 'showById']);

//Admin
Route::middleware('jwt.auth')->get('/users', [UserController::class, 'showAllUsers']);
