<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Propaganistas\LaravelPhone\PhoneNumber;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    private $counter = 0;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'number' => $this->generatePhoneNumberWithRandomDigit(),
            'password' => Hash::make('12345678'), // password
            'location' => fake()->locale(),
            'type' => fake()->randomElement(['office', 'client']),
            'verifyAccount'=> true,
        ];
    }

    /**
     * Generate a phone number with a random digit appended.
     *
     * @return string
     */
    private function generatePhoneNumberWithRandomDigit(): string
    {
        // Define the base phone number
        $basePhoneNumber = '+96391111111';

        // Generate a random digit
        $randomDigit = $this->counter;
        $this->counter++;
        // Append the random digit to the base phone number
        return $basePhoneNumber . $randomDigit;
    }

    public function admin(): static
    {
        return $this->state([
            'number' => '+963999999999',
            'type' => 'admin', // Set type to admin
        ]);
    }

    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
