<?php

namespace App\Http\Controllers;

use App\Models\BoardTemplate;
use App\Models\Game;
use Illuminate\Support\Facades\Auth;

class WelcomeController extends Controller
{
    public function index()
    {
        $templates = BoardTemplate::with('extraRules')
            ->get()
            ->map(fn ($template) => [
                'id' => $template->id,
                'size_x' => $template->size_x,
                'size_y' => $template->size_y,
                'resources' => $template->resources,
                'extra_rules' => $template->extraRules->mapWithKeys(fn ($rule) => [
                    $rule->name => $rule->pivot->value,
                ]),
            ]);

        $user = Auth::user();
        if ($user == null) {
            return view('welcome_stranger', [
                'templates' => $templates,
            ]);
        }

        $games = Game::playsIn($user->id)
            ->with(['player1', 'player2'])
            ->get()
            ->map(fn ($game) => [
                'id' => $game->id,
                'player1' => $game->player1->username,
                'player2' => $game->player2->username,
                'template_id' => $game->template_id,
                'turn' => $game->turn,
                'player1_state' => $game->player1_state,
                'player2_state' => $game->player2_state,
            ]);

        return view('welcome', [
            'username' => Auth::user()->username ?? null,
            'templates' => $templates,
            'games' => $games,
        ]);
    }
}
