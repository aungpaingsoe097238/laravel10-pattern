<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->word(),
            'category_id' => Category::inRandomOrder()->first()->id,
            'description' => fake()->realText(),
            'created_at' => Carbon::now()->subDays(rand(1, 30)),
            'updated_at' => Carbon::now()->subDays(rand(1, 30)),
        ];
    }
}
