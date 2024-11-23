<?php

namespace Database\Seeders;

use App\Models\BoardTemplate;
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
            'username' => 'Test User',
        ]);

        BoardTemplate::factory()->create([
            'size_x' => 11,
            'size_y' => 11,
            'resources' => [],
            'extra_rules' => [],
        ]);
    }
}
