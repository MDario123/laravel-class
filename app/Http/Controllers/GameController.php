<?php

namespace App\Http\Controllers;

use App\Models\BoardTemplate;
use App\Models\Game;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GameController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        return view('games.create', ['template_id' => $request->template_id]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated_data = $request->validate([
            'template_id' => ['required', 'numeric', 'integer'],
            'player2' => ['required'],
        ]);

        $template = BoardTemplate::findOrFail($validated_data['template_id']);
        $player2 = User::where('username', '=', $validated_data['player2'])->first();

        if ($player2 == null) {
            return redirect()->back();
        }

        $player1 = Auth::user();

        $initial_player_state = json_encode($template->initialPlayerState());

        Game::create([
            'template_id' => $template->id,
            'player1_id' => $player1->id,
            'player2_id' => $player2->id,
            'player1_state' => $initial_player_state,
            'player2_state' => $initial_player_state,
        ]);

        return redirect()->route('welcome')
            ->with('success', 'Game created successfully!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return view('games.edit');
    }

    /**
     * This is the core of this whole thing.
     */
    public function update(Request $request, string $id)
    {
        //
    }
}
