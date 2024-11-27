<?php

namespace App\Http\Controllers;

use App\Models\BoardTemplate;
use App\Models\ExtraRule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BoardTemplateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
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

        return view('templates.index', ['templates' => $templates]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('templates.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated_data = $request->validate([
            'size_x' => ['required', 'numeric', 'integer', 'min:2', 'max:20'],
            'size_y' => ['required', 'numeric', 'integer', 'min:2', 'max:20'],
            'resources' => ['required', 'json'],
            'extra_rules' => ['required', 'json'],
        ]);

        $template = new BoardTemplate;

        $template->size_x = $validated_data['size_x'];
        $template->size_y = $validated_data['size_y'];
        $template->setResourcesDirectly($validated_data['resources']);

        $erF = ExtraRule::all();
        $er = $erF->mapWithKeys(function ($rule) {
            return [$rule->name => $rule->validation];
        })->toArray();

        $er1 = json_decode($validated_data['extra_rules'], associative: true);
        Validator::validate($er1, $er);

        $template->save();

        $meaningful_extra_rules = [];

        foreach ($erF as $rule) {
            if ($er1[$rule->name] ?? null != null) {
                $meaningful_extra_rules[$rule->id] = ['value' => $er1[$rule->name]];
            }
        }

        $template->extraRules()->sync($meaningful_extra_rules);

        return redirect()->route('templates')
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
            ->mapWithKeys(function ($rule) {
                return [$rule->name => $rule->pivot->value];
            });

        return view('templates.edit', [
            'template' => $template,
            'extra_rules' => $extra_rules,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated_data = $request->validate([
            'size_x' => ['required', 'numeric', 'integer', 'min:2', 'max:20'],
            'size_y' => ['required', 'numeric', 'integer', 'min:2', 'max:20'],
            'resources' => ['required', 'json'],
            'extra_rules' => ['required', 'json'],
        ]);

        $template = BoardTemplate::findOrFail($id);

        $template->size_x = $validated_data['size_x'];
        $template->size_y = $validated_data['size_y'];
        $template->setResourcesDirectly($validated_data['resources']);

        $erF = ExtraRule::all();
        $er = $erF->mapWithKeys(function ($rule) {
            return [$rule->name => $rule->validation];
        })->toArray();

        $er1 = json_decode($validated_data['extra_rules'], associative: true);
        Validator::validate($er1, $er);

        $meaningful_extra_rules = [];

        foreach ($erF as $rule) {
            if ($er1[$rule->name] ?? null != null) {
                $meaningful_extra_rules[$rule->id] = ['value' => $er1[$rule->name]];
            }
        }

        $template->extraRules()->sync($meaningful_extra_rules);

        if ($template->isDirty()) {
            $template->save();
        }

        return redirect()->route('templates')
            ->with('success', 'Template updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
