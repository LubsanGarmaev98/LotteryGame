<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LotteryGame extends Model
{
    use HasFactory;

    public function getMatches(): hasMany
    {
        $matches = $this->hasMany(LotteryGameMatch::class, 'game_id', 'id');
        return $matches->orderByDesc('start_date')->orderByDesc('start_time');
    }
}
