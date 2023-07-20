<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLotteryGameMatchRequest;
use App\Models\LotteryGame;
use App\Models\LotteryGameMatch;
use Illuminate\Http\JsonResponse;

class LotteryGameMatchController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreLotteryGameMatchRequest  $request
     * @return JsonResponse
     */
    public function store(StoreLotteryGameMatchRequest $request): JsonResponse
    {
        $data = $request->validated();

        $game = LotteryGame::query()->find($data['game_id']);
        if (!empty($game)) {
            return response()->json([
                'error' => 'Такой игры не существует!'
            ], 401);
        }

        $lotteryGame = LotteryGameMatch::query()->create([
            'game_id'       => $game->id,
            'start_date'    => $data['date'],
            'start_time'    => $data['time'],
            'is_finished'   => false
        ]);

        return response()->json([
            'message' => $lotteryGame
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function update(int $id): JsonResponse
    {
        /** @var LotteryGameMatch $lotteryGameMatch */
        $lotteryGameMatch = LotteryGameMatch::query()->find($id);
        if (empty($lotteryGameMatch)) {
            return response()->json([
                'error' => 'LotteryGameMatch with ' . $id . ' not found'
            ]);
        }

        if (!$lotteryGameMatch->is_finished) {
            return response()->json([
                'error' => 'LotteryGameMatch with ' . $id . ' already finished'
            ]);
        }

        try {
            $lotteryGameMatch->is_finished = true;
            $lotteryGameMatch->save();
        } catch (\Exception $exception) {
            return response()->json([
                'error' => $exception->getMessage()
            ]);
        }

        return response()->json([
            'message'   => $lotteryGameMatch,
            'result'    => 'Success'
        ]);
    }
}
