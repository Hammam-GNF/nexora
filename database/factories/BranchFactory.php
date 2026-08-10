<?php

namespace Database\Factories;

use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<\App\Models\Branch>
 */
class BranchFactory extends Factory
{
    public function definition(): array
    {
        return [
            'company_id' => Company::factory(),
            'code' => fake()->unique()->bothify('BR-####'),
            'name' => fake()->company(),
            'phone' => fake()->phoneNumber(),
            'address' => fake()->address(),
            'is_active' => true,
        ];
    }
}
