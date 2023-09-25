<?php

namespace Database\Factories;

use Carbon\Carbon;
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
            'name' => fake()->company(),
            'website' => fake()->url(),
            'information' => fake()->paragraph(6),
            //'paper_topics' => implode(', ', [Str::random(30), Str::random(30), Str::random(30)]),
            'email' => fake()->companyEmail(),
            'published' => true,
            'status' => 0,
            'logo' => 'event_logos/Placeholder.jpg',
            'organizer' => fake()->company(),
            'organizer_email' => fake()->companyEmail(),
            'organizer_website' => fake()->url(),
            'subscription_start' => fake()->dateTimeBetween('-2 days', '+2 days')->setTime(0,0,0),
            'subscription_deadline' => fake()->dateTimeInInterval('+2 days', '+4 days')->setTime(23,59,59),
            'submission_start' => fake()->dateTimeInInterval('+4 days', '+6 days')->setTime(0,0,0),
            'submission_deadline' => fake()->dateTimeInInterval('+6 days', '+8 days')->setTime(23,59,59),
        ];
    }
}
