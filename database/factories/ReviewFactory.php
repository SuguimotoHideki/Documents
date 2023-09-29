<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Review>
 */
class ReviewFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'document_id' => '',
            'user_id' => '',
            'title' => fake()->bs(),
            'score' => rand(0, 10),
            'comment' => fake()->paragraph(6),
            'moderator_comment' => fake()->paragraph(6),
            'recommendation' => rand(0, 2),
        ];
    }
}
