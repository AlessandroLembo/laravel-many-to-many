<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Technology;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;


class TechnologyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $technologies = Technology::simplePaginate(3);

        return view('admin.technologies.index', compact('technologies'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $technology = new Technology();
        return view('admin.technologies.create', compact('technology'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'label' => 'required|string|unique:types|max:15',
            'color' => 'nullable|string',
        ], [
            'label.required' => 'La tecnologia deve avere un label',
            'label.max' => 'La tecnologia deve avere massimo :max caratteri',
            'label.unique' => 'Esiste già una tecnlogia con questo nome',
        ]);

        $data = $request->all();

        $technology = new Technology();

        $technology->fill($data);

        $technology->save();

        return to_route('admin.technologies.index')->with('type', 'success')->with('message', 'Nuova Tecnologia registrata con successo');
    }

    /**
     * Display the specified resource.
     */
    public function show(Technology $technology)
    {
        return to_route('admin.technologies.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Technology $technology)
    {
        return view('admin.technologies.edit', compact('technology'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Technology $technology)
    {
        $request->validate([
            'label' => ['required', 'string', Rule::unique('technologies')->ignore($technology->id), 'max:15'],
            'color' => 'nullable|string',
        ], [
            'label.required' => 'La tecnologia deve avere un label',
            'label.max' => 'La tecnologia deve avere massimo :max caratteri',
            'label.unique' => 'Esiste già una tecnlogia con questo nome',
        ]);

        $data = $request->all();

        $technology->fill($data);
        $technology->save();


        return to_route('admin.technologies.index')->with('type', 'success')->with('message', 'Tecnologia modificata con successo');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Technology $technology)
    {
        $technology->delete();

        return to_route('admin.technologies.index')->with('type', 'success')->with('message', "Tecnologia $technology->label eliminato con successo");
    }
}
