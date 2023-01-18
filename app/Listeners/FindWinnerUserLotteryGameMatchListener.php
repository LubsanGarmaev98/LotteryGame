<?php

namespace App\Listeners;

use App\Events\BeforeUpdateLotteryGameMatch;
use App\Models\LotteryGameMatch;
use App\Models\LotteryGameMatchUser;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class FindWinnerUserLotteryGameMatchListener
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
     * @param  \App\Events\BeforeUpdateLotteryGameMatch  $event
     * @return void
     */
    public function handle(BeforeUpdateLotteryGameMatch $event)
    {
        $arrUsersId = [];
        $lotteryGameUsers = LotteryGameMatchUser::where('lottery_game_match_id', '=', $event->lotteryGameMatch->id)->get();
        foreach ($lotteryGameUsers as $item)
        {
            $arrUsersId[] = $item->user_id;
        }
        $winnerUser = User::find($arrUsersId[array_rand($arrUsersId)]);

        $event->lotteryGameMatch->winner_id = $winnerUser->id;
    }
}
