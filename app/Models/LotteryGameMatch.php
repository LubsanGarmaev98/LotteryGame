<?php

namespace App\Models;

use App\Events\AfterUpdatedLotteryGameMatch;
use App\Events\BeforeUpdateLotteryGameMatch;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LotteryGameMatch extends Model
{
    use HasFactory;

    protected $fillable = [
        'game_id',
        'start_date',
        'start_time',
        'is_finished'
    ];

    protected $dispatchesEvents = [
        'updating' => BeforeUpdateLotteryGameMatch::class,
        'updated' => AfterUpdatedLotteryGameMatch::class
    ];
}
