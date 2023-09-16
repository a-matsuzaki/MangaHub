<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MangaSeries>
 */
class MangaSeriesFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => \App\Models\User::inRandomOrder()->first()->id,
            'title'       => $this->faker->word(),
            'author'      => $this->faker->name(),
            'publication' => $this->faker->company(),
            'note'        => $this->faker->realText(),
        ];
    }
}
