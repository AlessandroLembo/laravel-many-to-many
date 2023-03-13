<?php

namespace App\Http\Controllers\Admin;

use App\Models\Project;
use App\Models\Type;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Raccologo in filter ciò che mi arriva in request dall'invio del form della select
        $filter = $request->query('filter');

        $query = Project::orderby('id');

        // Aggiungo il filtro prima di impaginare
        if ($filter) {
            $value = $filter === 'drafts' ? 0 : 1;
            $query->where('is_published', $value);
        }

        $projects = $query->simplePaginate(3); // con questo metodo mi arrivano in pagina i link Next e Prev

        return view('admin.projects.index', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $project = new Project();
        $types = Type::orderBy('label')->get();
        return view('admin.projects.create', compact('project', 'types'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // validazione
        $request->validate([
            'name' => 'required|string|unique:projects',
            'description' => 'nullable|string',
            'type_id' => 'nullable|exists:types,id',
            'image' => 'nullable|image', // validazione che controlla che ci sia un'immagine, posso anche speficare le estensioni
            'project_for' => 'string',
            'web_platform' => 'nullable|string',
            'duration_project' => 'nullable|string',
        ], [
            'name.required' => 'Il nome del progetto è obbligatorio',
            'name.unique' => "Esiste già un progetto con il nome $request->name",
            'image.image' => 'Il file caricato deve essere di tipo immagine',
            'type_id' => 'Type non valido'

        ]);

        $data = $request->all();

        $new_project = new Project();

        // controllo se mi arriva un file immagine nell'array data (potrei usare anche una funzione datami dagli helper di laravel)
        if (array_key_exists('image', $data)) {
            /* se sono qui c'è l'immagine e salvo l'url nello Storage con una Facades:
               primo argomento cartella dove voglio salvare,
               secondo argomento cosa voglio salvare.
            */
            $image_url = Storage::put('projects', $data['image']);

            // Abbiamo l'url e lo assegno alla chiave image dell'array
            $data['image'] = $image_url;
        }

        // Non possiamo fare fill() diretto perchè il database accetta solo stringhe,
        // quindi devo prima salvare il file nello storage e ottenere la stringa (link allo storage) da poter salvare nel database
        $new_project->fill($data);

        // Se non ho checkato il checkbox nell'array data non c'è la chiave is_published (c'e solo se è checkata) 
        $new_project->is_published = Arr::exists($data, 'is_published'); // quindi devo controllare se esiste la chiave "is_published" 

        $new_project->save();

        return to_route('admin.projects.show', $new_project->id)->with('type', 'success')->with('Creazione progetto andata a buon fine');
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        return view('admin.projects.show', compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {
        $types = Type::orderBy('label')->get();

        return view('admin.projects.edit', compact('project', 'types'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Project $project)
    {
        $request->validate([
            // Il metodo ignore sui campi unique non ostacola l'aggiornamento dello stesso progetto
            'name' => ['required', 'string', Rule::unique('projects')->ignore($project->id)],
            'description' => 'nullable|string',
            'type_id' => 'nullable|exists:types,id',
            'image' => 'nullable|image', // validazione che controlla che sia un'immagine, posso anche speficare le estensioni
            'project_for' => 'string',
            'web_platform' => 'nullable|string',
            'duration_project' => 'nullable|string',
        ], [
            'name.required' => 'Il nome del progetto è obbligatorio',
            'name.unique' => "Esiste già un progetto con il nome $request->name",
            'image.image' => 'Il file caricato deve essere di tipo immagine',
            'type_id' => 'Type npn valido'

        ]);

        $data = $request->all();

        if (array_key_exists('image', $data)) {
            // Se c'è già un'immagine la cancello per lasciar spazio alla nuova che voglio caricare
            if ($project->image) Storage::delete($project->image);

            /* se sono qui c'è l'immagine e salvo l'url nello Storage con una Facades:
               primo argomento cartella dove voglio salvare,
               secondo argomento cosa voglio salvare.
            */
            $image_url = Storage::put('projects', $data['image']);

            // Abbiamo l'url e lo assegno alla chiave image dell'array
            $data['image'] = $image_url;
        }

        // update fa i metodi fill() e save() insieme
        // $project->update($data);
        $project->fill($data);

        $project->is_published = Arr::exists($data, 'is_published');

        $project->save();

        return to_route('admin.projects.show', $project->id)->with('type', 'success')->with('message', "Modifiche al progetto '$project->name' apportate con successo");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        // Controlliamo se c'è un'immagine nel progetto da eliminare e la cancello
        if ($project->image) Storage::delete($project->image);

        // prendo il progetto e lo elimino
        $project->delete();

        // Faccio il redirect alla pagina index e stampo il messaggio di conferma eliinazione
        return to_route('admin.projects.index')->with('type', 'danger')->with('message', "Il progetto '$project->name' è stato cancellato con successo");
    }

    public function toggle(Project $project)
    {
        $project->is_published = !$project->is_published;

        $action = $project->is_published ? 'publlicato' : 'salvato in bozza';
        $type = $project->is_published ? 'success' : 'info';

        $project->save();

        // Ritorno alla pagina precedente
        return redirect()->back()->with('type', $type)->with('message', "Il progetto è stato $action con sucesso");
    }
}
