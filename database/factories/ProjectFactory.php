<?php

namespace Database\Factories;

use App\Enums\StatusPekerjaan;
use App\Models\Vendor;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Project>
 */
class ProjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        static $paIndex = 1;
        static $contractIndex = 1;

        $year = now()->year;
        $month = now()->format('m');

        // generate tanggal acak yang valid untuk disposition dan target
        $dispositionDate = $this->faker->dateTimeBetween('-2 months', 'now');
        $targetDate = $this->faker->dateTimeBetween($dispositionDate, '+2 months');

        return [
            'pa_number' => $year . $month . str_pad($paIndex++, 5, '0', STR_PAD_LEFT),
            'contract_number' => str_pad($contractIndex++, 3, '0', STR_PAD_LEFT) . '/SAP/' . $year . '/' . str_pad(rand(1, 999), 3, '0', STR_PAD_LEFT),
            'customer_name' => $this->faker->company,
            'customer_address' => $this->faker->address,
            'ptl' => $this->faker->name,
            'disposition_date' => $dispositionDate->format('Y-m-d'),
            'target_date' => $targetDate->format('Y-m-d'),
            'duration' => Carbon::parse($dispositionDate)->diffInDays($targetDate),
            'type' => $this->faker->randomElement(array_map(fn($case) => $case->value, StatusPekerjaan::cases())),
            'vendor_id' => Vendor::factory(),
        ];
    }
}
