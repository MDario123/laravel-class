<?php

namespace App\Http\Controllers;

use App\Models\BoardTemplate;
use App\Models\ExtraRule;
use App\Rules\ValidResources;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BoardTemplateController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('templates.create', [
            'template' => [
                'size_x' => 11,
                'size_y' => 11,
                'resources' => [
                    'x' => 6,
                    'y' => 6,
                    'type' => 'Water',
                ],
            ],
            'extra_rules' => [],
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate
        $validated_data = $request->validate([
            'size_x' => ['required', 'numeric', 'integer', 'min:2', 'max:20'],
            'size_y' => ['required', 'numeric', 'integer', 'min:2', 'max:20'],
            'resources' => ['required', new ValidResources],
            'extra_rules' => ['required', 'json'],
        ]);

        $possible_extra_rules = ExtraRule::all();
        $rule_validation = $possible_extra_rules
            ->mapWithKeys(fn ($rule) => [$rule->name => $rule->validation])
            ->toArray();

        $er1 = json_decode($validated_data['extra_rules'], associative: true);
        Validator::validate($er1, $rule_validation);

        // Store plain data
        $template = new BoardTemplate;

        $template->size_x = $validated_data['size_x'];
        $template->size_y = $validated_data['size_y'];
        $template->setResourcesDirectly($validated_data['resources']);

        $template->save();

        // Store extra rules
        $meaningful_extra_rules = [];

        foreach ($possible_extra_rules as $rule) {
            $rule_value = $er1[$rule->name] ?? null;
            if ($rule_value != null) {
                $meaningful_extra_rules[$rule->id] = ['value' => $rule_value];
            }
        }

        $template->extraRules()->sync($meaningful_extra_rules);

        // And finally redirect to index
        return redirect()->route('welcome')
            ->with('success', 'Template created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return view('templates.show', ['template' => BoardTemplate::findOrFail($id)]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $template = BoardTemplate::findOrFail($id);
        $extra_rules = $template
            ->extraRules
            ->mapWithKeys(fn ($rule) => [$rule->name => $rule->pivot->value]);

        return view('templates.create', [
            'template' => $template,
            'extra_rules' => $extra_rules,
        ]);
    }
}
