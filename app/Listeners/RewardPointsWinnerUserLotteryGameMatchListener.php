<?php

namespace App\Listeners;

use App\Events\AfterUpdatedLotteryGameMatch;
use App\Events\BeforeUpdateLotteryGameMatch;
use App\Models\LotteryGame;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class RewardPointsWinnerUserLotteryGameMatchListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\AfterUpdatedLotteryGameMatch  $event
     * @return void
     */
    public function handle(AfterUpdatedLotteryGameMatch $event)
    {
        $lotteryGame = LotteryGame::find($event->lotteryGameMatch->game_id);
        $points = $lotteryGame->reward_points;

        $user = User::find($event->lotteryGameMatch->winner_id);
        $user->points += $points;
        $user->save();
    }
}
