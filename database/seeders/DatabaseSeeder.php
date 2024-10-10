<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Order;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            NewsSeeder::class,
            NewsDepartmentSeeder::class,
            EstateSeeder::class,
            CompanySeeder::class,
            OrderSeeder::class,
            CurrencySeeder::class,
            AdminUserSeeder::class
        ]);
    }
}
