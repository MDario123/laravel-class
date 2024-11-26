<?php

namespace Database\Seeders;

use App\Models\BoardTemplate;
use App\Models\ExtraRules;
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

        ExtraRules::factory()->createMany([
            [
                'name' => 'allow_negative_gold',
                'validation' => 'required|boolean',
            ],
            [
                'name' => 'initial_gold',
                'validation' => 'required|integer|numeric|min:0',
            ],
        ]);

        BoardTemplate::factory()->create([
            'size_x' => 11,
            'size_y' => 11,
            'resources' => [],
            'extra_rules' => '{}',
        ]);
    }
}
