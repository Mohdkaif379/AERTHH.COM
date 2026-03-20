<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class AdminFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'password' => bcrypt('12345678'),
            'profile' => null,
            'phone' => fake()->phoneNumber(),
            'status' => 1,
        ];
    }
}