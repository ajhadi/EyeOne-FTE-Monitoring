<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\ProjectUpdate;
use App\Models\Vendor;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VendorAndProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Buat 5 vendor, masing-masing dengan 3 proyek
        Vendor::factory()
            ->count(20)
            ->create()
            ->each(function ($vendor) {
                $projects = Project::factory()->count(3)->create([
                    'vendor_id' => $vendor->id
                ]);

                foreach ($projects as $project) {
                    ProjectUpdate::factory()->count(3)->create([
                        'project_id' => $project->id,
                        'vendor_id' => $vendor->id,
                        'date' => now()->addDays(rand(1, 10))->format('Y-m-d'), // atau sesuaikan logikanya
                    ]);
                }
            });
    }
}

//Project::factory()->count(25)->create([
//    'vendor_id' => 5
//]);
//
//foreach ($projects as $project) {
//    ProjectUpdate::factory()->count(100)->create([
//        'project_id' => $project->id,
//        'vendor_id' => $project->vendor_id,
//        'date' => now()->addDays(rand(1, 10))->format('Y-m-d'), // atau sesuaikan logikanya
//    ]);
//}
