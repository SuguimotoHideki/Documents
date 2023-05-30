<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::create([
            'user_name' => 'admin',
            'cpf' => '03698481103',
            'user_email' => 'admin@email.com',
            'password' => Hash::make('P0rt4l*05_set_2022#'),
        ]);

        $admin->assignRole('admin');
    }
}
