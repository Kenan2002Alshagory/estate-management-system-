<?php

namespace Database\Factories;

use App\Models\News;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\NewsDepartment>
 */
class NewsDepartmentFactory extends Factory
{
    protected $model = \App\Models\NewsDepartment::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence,
            'body' => $this->faker->paragraph,
            'video' => $this->faker->url, // Fake video URL
            'news_id' => News::inRandomOrder()->first()->id, // Create a related News entry
        ];
    }
}
