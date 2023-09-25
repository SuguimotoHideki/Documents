<?php

namespace Database\Seeders;

use App\Models\SubmissionType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SubmissionTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $submission_types = [
            'artigo',
            'resumo',
            'monografia'
        ];

        foreach($submission_types as $type)
        {
            SubmissionType::create([
                'name' => $type,
            ]);
        }
    }
}
