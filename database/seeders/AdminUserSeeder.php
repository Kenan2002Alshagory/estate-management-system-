<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create a user with admin role
        User::factory()->admin()->create([
            'name' => 'admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'), // password
            'location' => fake()->locale(),
            'verifyAccount'=> true,
        ]);
    }
}
