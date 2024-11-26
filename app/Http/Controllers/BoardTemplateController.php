<?php

namespace App\Http\Controllers;

use App\Models\BoardTemplate;
use Illuminate\Http\Request;

class BoardTemplateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('templates.index', ['templates' => BoardTemplate::all()]);
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
        $template->extra_rules = $validated_data['extra_rules'];

        $template->save();

        return redirect()->route('templates')
            ->with('success', 'Template created successfully!');
    }
    // "[{\"x\":1,\"y\":1,\"type\":\"Water\"}]"

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
        return view('templates.edit', ['template' => BoardTemplate::findOrFail($id)]);
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
        $template->extra_rules = $validated_data['extra_rules'];

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
