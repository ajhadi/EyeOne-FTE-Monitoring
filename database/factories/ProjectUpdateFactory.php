<?php

namespace Database\Factories;

use App\Enums\StatusPekerjaan;
use App\Enums\TipeKendala;
use App\Models\Project;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProjectUpdate>
 */
class ProjectUpdateFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $project = Project::inRandomOrder()->first() ?? Project::factory()->create();
        $vendor = $project->vendor;

        // Buat tanggal update setelah project dibuat
        $updateDate = Carbon::parse($project->created_at)->addDays(rand(1, 15));

        return [
            'date' => $updateDate->format('Y-m-d'),
            'vendor_id' => $vendor->id,
            'project_id' => $project->id,
            'job_status' =>  $this->faker->randomElement(array_map(fn($case) => $case->value, StatusPekerjaan::cases())),
            'problem_status' => $this->faker->randomElement(array_map(fn($case) => $case->value, TipeKendala::cases())),
            'problem_details' => $this->faker->boolean(30) ? $this->faker->sentence(10) : '',
            'estimated_pull' => $this->faker->numberBetween(5000, 25000),
            'actual_pull' => $this->faker->numberBetween(1000, 10000),
            'estimated_tracing' => $this->faker->numberBetween(5000, 25000),
            'actual_tracing' => $this->faker->numberBetween(1000, 10000),
        ];
    }
}
