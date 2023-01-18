<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLotteryGameMatchUserRequest;
use App\Models\LotteryGameMatch;
use App\Models\LotteryGameMatchUser;

class LotteryGameMatchUserController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreLotteryGameMatchUserRequest $request)
    {
        $params = $request->validated();

        $user = auth()->user();
        $lotteryGameMatch = LotteryGameMatch::find($params['LotteryGameMatchId']);

        if(empty($lotteryGameMatch))
        {
            return response()->json(['error' => 'Указанного матча не существует!']);
        }

        $lotteryGameMatchUser = LotteryGameMatchUser::create([
            'user_id' => $user->id,
            'lottery_game_match_id' => $lotteryGameMatch->id
        ]);

        return response()->json(['message' => $lotteryGameMatchUser]);
    }
}
