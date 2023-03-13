<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Type;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;


class TypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $types = Type::simplePaginate(3);

        return view('admin.types.index', compact('types'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $type = new Type();
        return view('admin.types.create', compact('type'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'label' => 'required|string|unique:types|max:15',
            'color' => 'nullable|string|size:7',
        ], [
            'label.required' => 'Il tipo selezionato deve avere un label',
            'label.max' => 'Il tipo deve avere massimo :max caratteri',
            'label.unique' => 'Esiste già un tipo con questo nome',
            'color.size' => 'Il colore deve essere un esadecimale',
        ]);

        $data = $request->all();

        $type = new Type();

        $type->fill($data);

        $type->save();

        return to_route('admin.types.index')->with('type', 'success')->with('message', 'Nuovo type rgistrato con successo');
    }

    /**
     * Display the specified resource.
     */
    public function show(Type $type)
    {
        return to_route('admin.types.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Type $type)
    {
        return view('admin.types.edit', compact('type'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Type $type)
    {


        $request->validate([
            'label' => ['required', 'string', Rule::unique('types')->ignore($type->id), 'max:15'],
            'color' => 'nullable|string|size:7',
        ], [
            'label.required' => 'Il tipo selezionato deve avere un label',
            'label.max' => 'Il tipo deve avere massimo :max caratteri',
            'label.unique' => 'Esiste già un tipo con questo nome',
            'color.size' => 'Il colore deve essere un esadecimale',
        ]);

        $data = $request->all();

        $type->fill($data);
        $type->save();


        return to_route('admin.types.index')->with('type', 'success')->with('message', 'Type modificato con successo');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Type $type)
    {
        $type->delete();

        return to_route('admin.types.index')->with('type', 'success')->with('message', "Type $type->label eliminato con successo");
    }
}
