<?php

namespace Database\Factories;

use App\Models\Movie;
use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Screen;

class ScheduleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'movie_id' => Movie::factory(),
            'screen_id' => Screen::factory(),
            'start_time' => CarbonImmutable::now(),
            'end_time' => CarbonImmutable::now()->addHours(2),
        ];
    }
}