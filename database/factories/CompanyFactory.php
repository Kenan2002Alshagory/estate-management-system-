<?php

namespace Database\Factories;

use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Company>
 */
class CompanyFactory extends Factory
{
    protected $model = Company::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->company(),
            'image' => $this->faker->imageUrl(),  // Generates a fake image URL
            'description' => $this->faker->paragraph(),  // A short description
            'location' => $this->faker->address(),
            'block' => $this->faker->boolean(),  // Random block status (true/false)
            'type' => $this->faker->randomElement(['engineering_companies', 'real_estate_companies']),  // Random company type
        ];
    }
}
