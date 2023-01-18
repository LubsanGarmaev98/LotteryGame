<?php

namespace App\Listeners;

use App\Events\BeforeLotteryGameUserSaved;
use App\Models\LotteryGameMatchUser;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Ramsey\Uuid\Exception\TimeSourceException;
use Ramsey\Uuid\Exception\UnableToBuildUuidException;

class LotteryGameUserUniqueListener
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
     * @return false
     */
    public function handle(BeforeLotteryGameUserSaved $event)
    {
        $lotteryGameUser = LotteryGameMatchUser::where('user_id', '=', $event->lotteryGameMatchUser->user_id)
            ->where('lottery_game_match_id', '=', $event->lotteryGameMatchUser->lottery_game_match_id)
            ->first();

        if(!empty($lotteryGameUser))
        {
           return false;
        }
    }
}
