<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLotteryGameMatchUserRequest;
use App\Models\LotteryGameMatch;
use App\Models\LotteryGameMatchUser;
use Illuminate\Http\JsonResponse;

class LotteryGameMatchUserController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param StoreLotteryGameMatchUserRequest $request
     * @return JsonResponse
     */
    public function store(StoreLotteryGameMatchUserRequest $request): JsonResponse
    {
        $params = $request->validated();
        $user = auth()->user();

        $lotteryGameMatch = LotteryGameMatch::query()->find($params['LotteryGameMatchId']);
        if(empty($lotteryGameMatch)) {
            return response()->json([
                'error' => 'Указанного матча не существует!'
            ]);
        }

        $lotteryGameMatchUser = LotteryGameMatchUser::query()->create([
            'user_id' => $user->getAuthIdentifier(),
            'lottery_game_match_id' => $lotteryGameMatch->id
        ]);

        return response()->json(['message' => $lotteryGameMatchUser]);
    }
}
