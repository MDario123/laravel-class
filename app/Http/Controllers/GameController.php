<?php

namespace App\Http\Controllers;

use App\Models\BoardTemplate;
use App\Models\Game;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

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
        $parse_game = fn ($game) => [
            'id' => $game->id,
            'player1' => $game->player1->username,
            'player2' => $game->player2->username,
            'template_id' => $game->template_id,
            'turn' => $game->turn,
            'player1_state' => $game->player1_state,
            'player2_state' => $game->player2_state,
        ];

        $game = Game::with(['player1', 'player2'])
            ->findOrFail($id);
        $game = $parse_game($game);

        return view('games.edit', ['game' => $game]);
    }

    /**
     * This is the core of this whole thing.
     */
    public function update(Request $request, string $id)
    {
        // (I) Parse persistent data
        // Specifically, parse:
        // turn,
        // player1_state,
        // player2_state,
        // template,
        // extra_rules,
        // is_player1,
        // (II) Parse and validate move
        // move should always be 2 or 3 space separated integers.
        // If the 3rd one is not present, it's assumed to be 0.
        // Format:
        // x y [k]
        // (III) Store move
        // Simply store it in the game as either player1_move or player2_move
        // (IV) Execute move
        // If both player made their moves, execute them and advance to the next state.
        // (V) Save the current game

        // (I) Parse persistent data
        $game = Game::findOrFail($id);

        $turn = $game->turn;
        $player1_state = $game->player1_state;
        $player2_state = $game->player2_state;

        $template = $game->template;

        $extra_rules = $template->extraRules->mapWithKeys(fn ($rule) => [
            $rule->name => $rule->pivot->value,
        ]);

        $validated_data = $request->validate([
            'move' => ['required'],
        ]);

        $move = $validated_data['move'];

        $is_player1 = Auth::user()->id == $game->player1_id;
        $is_player2 = Auth::user()->id == $game->player2_id;

        if (! ($is_player1 || $is_player2)) {
            abort(404);
        }

        // (II) Parse and validate move
        $coordinates = explode(' ', $move, 3);

        if (count($coordinates) < 2) {
            throw ValidationException::withMessages([
                'Expected move format: "x y [k]". Where x, y, k integers.',
            ]);
        }

        // TODO: Validate that $x, $y, $k are really integers
        if (count($coordinates) == 2) {
            [$x, $y] = $coordinates;
            $x = (int) $x;
            $y = (int) $y;
            $k = 0;
        } else {
            [$x, $y, $k] = $coordinates;
            $x = (int) $x;
            $y = (int) $y;
            $k = (int) $k;
        }

        if (
            $x < 1 || $x > $template->size_x
            || $y < 1 || $y > $template->size_y
        ) {
            throw ValidationException::withMessages([
                'move coordinates should lie inside the board',
            ]);
        }

        // Special validation depending on the turn
        if ($turn == 0) {
            // TODO: Validate that the position does not contain a resource
        } elseif ($extra_rules->allow_negative_gold ?? false == false) {
            // TODO: Validate that you have enough gold in case the move produces a unit
        }

        // (III) Store move
        if ($is_player1) {
            $game->player1_move = $move;
        } else {
            $game->player2_move = $move;
        }

        // (IV) Execute move
        if ($game->player1_move != null && $game->player2_move != null) {
            if ($turn == 0) {
                // If both players played their moves update the state of the game
                if ($game->player1_move == $game->player2_move) {
                    // If they place their castle in the same position consider that none of this happened
                    $game->player1_move = null;
                    $game->player2_move = null;
                } else {
                    // Otherwise place the castles in their positions
                    $game->turn = 1;

                    [$x, $y] = explode(' ', $game->player1_move, 2);
                    $x = (int) $x;
                    $y = (int) $y;
                    $state = $game->player1_state;
                    $state['castle'] = [
                        'x' => $x,
                        'y' => $y,
                    ];

                    $game->player1_state = $state;

                    [$x, $y] = explode(' ', $game->player2_move, 2);
                    $x = (int) $x;
                    $y = (int) $y;
                    $state = $game->player2_state;
                    $state['castle'] = [
                        'x' => $x,
                        'y' => $y,
                    ];

                    $game->player2_state = $state;
                }
            } else {
            }
        }

        $game->save();

        return redirect()->back();
    }
}
