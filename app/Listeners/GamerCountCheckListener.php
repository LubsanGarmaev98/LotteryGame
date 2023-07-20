<?php

namespace App\Listeners;

use App\Events\BeforeLotteryGameUserSaved;
use App\Models\LotteryGame;
use App\Models\LotteryGameMatch;
use App\Models\LotteryGameMatchUser;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class GamerCountCheckListener
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
     * @param  \App\Events\BeforeLotteryGameUserSaved  $event
     * @return void
     */
    public function handle(BeforeLotteryGameUserSaved $event)
    {
        $lotteryGameMatch = LotteryGameMatch::find($event->lotteryGameMatchUser->lottery_game_match_id);
        $lotteryGame = LotteryGame::find($lotteryGameMatch->game_id);

        $lotteryGameUsers = LotteryGameMatchUser::where('lottery_game_match_id', '=', $event->lotteryGameMatchUser->lottery_game_match_id)->get();

        if($lotteryGame->gamer_count <= count($lotteryGameUsers))
        {
            return false;
        }
    }
}
