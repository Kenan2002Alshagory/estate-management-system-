<?php

namespace Database\Factories;

use App\Models\Currency;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Currency>
 */
class CurrencyFactory extends Factory
{
    protected $model = Currency::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->currencyCode(),  // Generate a random currency code (e.g. USD, EUR)
            'amount' => $this->faker->randomFloat(2, 1, 1000),  // Random amount between 1 and 1000
        ];
    }
}
