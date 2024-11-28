<?php

namespace Database\Seeders;

use App\Models\BoardTemplate;
use App\Models\ExtraRule;
use App\Models\Game;
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

        $user1 = User::factory()->create([
            'username' => 'user1',
        ]);

        $user2 = User::factory()->create([
            'username' => 'user2',
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

        $initial_player_state = json_encode($template->initialPlayerState());

        Game::factory()->create([
            'template_id' => $template->id,
            'player1_id' => $user1->id,
            'player2_id' => $user2->id,
            'player1_state' => $initial_player_state,
            'player2_state' => $initial_player_state,
        ]);
    }
}
