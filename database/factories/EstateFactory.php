<?php

namespace Database\Factories;

use App\Models\Estate;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Estate>
 */
class EstateFactory extends Factory
{
    protected $model = Estate::class;

    public function definition(): array
    {
        return [
            'type' => $this->faker->randomElement(['sale', 'rent', 'sold', 'rented']),
            'property_category' => $this->faker->randomElement(['commercial', 'residential', 'agricultural', 'industrial']),
            'indicators' => $this->faker->randomElement(['negotiable', 'residential', 'agricultural', 'industrial']),
            'name' => $this->faker->company(),
            'location' => $this->faker->address(),
            'description' => $this->faker->paragraph(),
            'code' => $this->faker->unique()->bothify('EST-#####'),
            'space' => $this->faker->randomFloat(2, 100, 1000),  // Example: 100 to 1000 sqm
            'number_of_bedrooms' => $this->faker->numberBetween(1, 10),
            'number_of_bathrooms' => $this->faker->numberBetween(1, 5),
            'number_of_floors' => $this->faker->numberBetween(1, 20),
            'number_of_parking_spaces' => $this->faker->numberBetween(0, 5),
            'year_of_construction' => $this->faker->date('Y-m-d', 'now'),
            'services' => json_encode($this->faker->randomElements(['water', 'electricity', 'internet', 'gas'], 3)), // Random services
            '3d_photo' => $this->faker->imageUrl(),  // Fake 3D photo URL
            'blueprint' => $this->faker->imageUrl(), // Fake blueprint image URL
            'video_url' => $this->faker->url(), // Fake video URL
            'price' => $this->faker->randomFloat(2, 10000, 500000), // Price range
            'rental_duration' => $this->faker->randomElement(['monthly', 'yearly']),
            'filters' => json_encode($this->faker->randomElements(['near_school', 'garden_view', 'close_to_transport'], 2)),
            'photos' => json_encode([$this->faker->imageUrl(), $this->faker->imageUrl()]),  // Multiple photo URLs
            // Assign a random existing user from the users table
            'user_id' => User::inRandomOrder()->first()->id,
            'start_date' => $this->faker->date(),
            'end_date' => $this->faker->date(),
        ];
    }
}
