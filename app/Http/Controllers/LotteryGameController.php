<?php

namespace App\Http\Controllers;

use App\Http\Requests\ShowByIdLotteryGameRequest;
use App\Models\LotteryGame;
use App\Models\LotteryGameMatch;
use Illuminate\Http\Request;

class LotteryGameController extends Controller
{
    public function showAll()
    {
        $lotteryGames = LotteryGame::with('getMatches')->get();

        return response()->json($lotteryGames);
    }

    public function showById(ShowByIdLotteryGameRequest $request)
    {
        $params = $request->validated();

        $lotteryGame = LotteryGame::find($params['lottery_game_id']);
        if(empty($lotteryGame))
        {
            return response()->json(['error' => 'Такой игры не существует!'], 401);
        }

        $lotteryGameMatches = $lotteryGame->getMatches()->get();

        return response()->json($lotteryGameMatches);
    }
}
