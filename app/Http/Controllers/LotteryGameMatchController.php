<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLotteryGameMatchRequest;
use App\Models\LotteryGame;
use App\Models\LotteryGameMatch;
use Carbon\Carbon;
use Illuminate\Http\Request;

class LotteryGameMatchController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreLotteryGameMatchRequest $request)
    {
        $params = $request->validated();
        $user = auth()->user();

        if($user->isAdmin())
        {
            $game = LotteryGame::find($params['game_id']);
            if(!empty($game))
            {

                $lotteryGame = LotteryGameMatch::create
                ([
                    'game_id' => $game->id,
                    'start_date' => $params['date'],
                    'start_time' => $params['time'],
                    'is_finished' => false
                ]);

                return response()->json(['message' => $lotteryGame]);
            }

            return response()->json(['error' => 'Такой игры не существует!'], 401);
        }

        return response()->json(['error' => 'Только администратор может создавать матчи'], 401);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\LotteryGameMatch  $lotteryGameMatch
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request)
    {
        $user = auth()->user();
        if($user->isAdmin())
        {
            $lotteryGameMatch = LotteryGameMatch::find($request->id);
            if(!$lotteryGameMatch->is_finished)
            {
                $lotteryGameMatch->is_finished = true;
                $lotteryGameMatch->save();
            }
            return response()->json(['message' => $lotteryGameMatch]);
        }

        return response()->json(['error' => 'Только администратор может изменять данные матча']);
    }
}
