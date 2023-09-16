<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MangaVolume>
 */
class MangaVolumeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'series_id' => \App\Models\MangaSeries::inRandomOrder()->first()->id,
            'user_id' => \App\Models\User::inRandomOrder()->first()->id,
            'type' => $this->faker->numberBetween(1, 10) <= 9, // 1-9の場合はtrue、10の場合はfalse
            'volume' => $this->faker->numberBetween(1, 100),
            'is_owned' => $this->faker->numberBetween(1, 10) <= 9, // 1-9の場合はtrue、10の場合はfalse
            'is_read' => $this->faker->boolean,
            'wants_to_buy' => $this->faker->boolean,
            'wants_to_read' => $this->faker->boolean,
            'note' => $this->faker->realText(),
        ];
    }
}
