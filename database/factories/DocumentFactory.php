<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Document;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Document>
 */
class DocumentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
                'title' => implode(' ', [fake()->catchPhrase(), fake()->bs()]),
                'keyword' => implode(', ', [fake()->word(), fake()->word(), fake()->word()]),
                'institution' => fake()->company(),
                'submission_type_id' => '',
                'attachment_author' => "submission_attachments/this.pdf",
                'attachment_no_author' => "submission_attachments/that.pdf",
        ];
    }
}
