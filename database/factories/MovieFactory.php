<?php

namespace Database\Factories;

use App\Models\Movie;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Movie>
 */
class MovieFactory extends Factory
{
    protected $model = Movie::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(3),
            'rating' => $this->faker->randomFloat(1, 0, 10),
            'age_restriction' => $this->faker->randomElement(['', '7', '12', '16']),
            'description' => $this->faker->paragraph,
            'premieres_at' => $this->faker->dateTimeBetween('-1 year', '+1 year')->format('Y-m-d H:i:s'),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
