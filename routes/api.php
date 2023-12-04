<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Authorization\LoginController;
use \App\Http\Controllers\PlayerDuelController;
use \App\Http\Controllers\CardsController;
use \App\Http\Controllers\PlayerController;

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

Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout']);

Route::group(['middleware' => ['auth:sanctum']], function () {

    //START THE DUEL
    Route::post('duels', [PlayerDuelController::class, 'startNewDuel']);

    //CURRENT GAME DATA
    Route::get('duels/active', [PlayerDuelController::class, 'getActiveDuel']);

    //User has just selected a card
    Route::post('duels/action', function (Request $request) {
        return response()->json();
    });

    //DUELS HISTORY
    Route::get('duels', [PlayerDuelController::class, 'getPastDuels']);

    //CARDS
    Route::post('cards', CardsController::class);

    //USER DATA
    Route::get('user-data', PlayerController::class);
});
