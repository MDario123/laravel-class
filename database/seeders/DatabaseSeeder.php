<?php

namespace Database\Seeders;

use App\Models\BoardTemplate;
use App\Models\ExtraRule;
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

        ExtraRule::factory()->createMany([
            [
                'name' => 'allow_negative_gold',
                'validation' => 'boolean',
            ],
            [
                'name' => 'initial_gold',
                'validation' => 'integer|numeric|min:0',
            ],
        ]);

        $template = BoardTemplate::factory()->create([
            'size_x' => 11,
            'size_y' => 11,
            'resources' => [],
        ]);

        $template->extraRules()->attach(2, ['value' => '20']);
    }
}
