<?php

namespace App\Http\Controllers;

use App\Models\BoardTemplate;
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

        return view('welcome', [
            'username' => Auth::user()->username ?? null,
            'templates' => $templates,
        ]);
    }
}
