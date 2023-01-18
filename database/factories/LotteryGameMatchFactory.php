<?php

namespace Database\Factories;

use App\Models\LotteryGame;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\LotteryGameMatch>
 */
class LotteryGameMatchFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'game_id' => LotteryGame::get()->random()->id,
            'start_date' => $this->faker->date(),
            'start_time' => $this->faker->time()
        ];
    }
}
