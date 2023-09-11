<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_name' => fake()->name(),
            'cpf' => substr(str_shuffle(str_repeat('0123456789', ceil(11 / 10))), 0, 11),
            'birth_date' => fake()->date(),
            'user_phone_number' => fake()->phoneNumber(),
            'user_institution' => fake()->company(),
            'user_email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => Hash::make('123'), // password
            'remember_token' => Str::random(10),
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (User $user) {
            // Assign roles to the user
            $randomNumber = rand(0, 2);

            // Assign roles based on the random number
            if ($randomNumber === 0) {
                $user->assignRole('user');
            } elseif($randomNumber === 1) {
                $user->assignRole(['event moderator']);
            }else{
                $user->assignRole(['reviewer']);
            }
        });
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
