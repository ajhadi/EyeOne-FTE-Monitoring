<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Vendor>
 */
class VendorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $companyName = $this->faker->company;
        $code = strtoupper(Str::substr(Str::slug($companyName, ''), 0, rand(2, 3)));

        return [
            'code' => $code,
            'name' => $companyName,
            'address' => $this->faker->address,
            'phone' => $this->faker->phoneNumber,
            'zone' => $this->faker->randomElement(['Area I', 'Area II', 'Area III']),
            'team_count' => $this->faker->numberBetween(1, 2),
            'members_per_team' => 5,
        ];
    }
}
