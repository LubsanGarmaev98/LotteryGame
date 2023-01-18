<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LotteryGame extends Model
{
    use HasFactory;

    public function getMatches()
    {
        $matches = $this->hasMany(LotteryGameMatch::class, 'game_id', 'id');
        return $matches->orderByDesc('start_date')->orderByDesc('start_time');
    }
}
