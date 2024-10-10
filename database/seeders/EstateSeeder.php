<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Estate;

class EstateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create 20 estates
        Estate::factory()->count(5)->create();
    }
}
