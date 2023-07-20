<?php

namespace App\Http\Controllers;

use App\Models\LotteryGame;
use Symfony\Component\HttpFoundation\JsonResponse;

class LotteryGameController extends Controller
{
    public function showAll(): JsonResponse
    {
        $lotteryGames = LotteryGame::with('getMatches')->get();

        return response()->json([
            'data' => $lotteryGames
        ]);
    }

    public function showById(int $id): JsonResponse
    {
        /** @var LotteryGame $lotteryGame */
        $lotteryGame = LotteryGame::query()->find($id);
        if (empty($lotteryGame)) {
            return response()->json([
                'error' => 'Такой игры не существует!'
            ], 401);
        }

        $lotteryGameMatches = $lotteryGame->getMatches()->get();
        if (empty($lotteryGameMatches)) {
            return response()->json([
                'error' => 'Not found Lottery Game Match!'
            ], 401);
        }

        return response()->json([
            'data'=> $lotteryGameMatches
        ]);
    }
}
