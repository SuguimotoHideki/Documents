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
            'user_institution' => 'Fiocruz MS',
            'user_email' => 'admin@email.com',
            'password' => Hash::make('123@senha'),
        ]);

        $admin->assignRole('admin');
    }
}
