<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event>
 */
class EventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'event_name' => fake()->company(),
            'event_website' => fake()->url(),
            'event_information' => Str::random(100),
            'paper_topics' => implode(', ', [Str::random(30), Str::random(30), Str::random(30)]),
            'event_email' => fake()->companyEmail(),
            'event_status' => 0,
            'organizer' => fake()->company(),
            'organizer_email' => fake()->companyEmail(),
            'organizer_website' => fake()->url(),
            'subscription_start' => fake()->date(),
            'subscription_deadline' => fake()->date(),
            'submission_start' => fake()->date(),
            'submission_deadline' => fake()->date(),
        ];
    }
}
