<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\NewsDepartment;

class NewsDepartmentSeeder extends Seeder
{
    public function run()
    {
        // Create 10 news departments, each associated with a news item
        NewsDepartment::factory()->count(2)->create();
    }
}
