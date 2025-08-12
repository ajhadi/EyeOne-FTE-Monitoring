<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Yoga Prasetiyo',
            'email' => 'yoga.xv@gmail.com',
            'workos_id' => 'user_01K21AAJQY8JVQSKYF6CSM51PX'
        ]);

        User::factory()->member()->create([
            'name' => 'Martine Indra S',
            'email' => 'smartineindra@gmail.com',
            'workos_id' => 'user_01K224T0RGQTTA3B6G3NFYAQDH'
        ]);

        User::factory()->create([
            'name' => 'Joel Chrisgian Saputra',
            'email' => 'joel.chrisgians@gmail.com',
            'workos_id' => 'user_01K282BHA76029JVFPMGESN3TQ'
        ]);

        User::factory()->member()->create([
            'name' => 'Vendor',
            'email' => 'kesayanganlrca@gmail.com',
            'workos_id' => 'user_01K282DK2JA57FBQ7TQV8P3R71'
        ]);

        $this->call([
            VendorAndProjectSeeder::class,
        ]);
    }
}
