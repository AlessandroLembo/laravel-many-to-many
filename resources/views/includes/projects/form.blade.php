{{-- Dopo aver creato un nuovo progetto nel metodo create e in base al fatto 
    che esiste o meno (id) col form distinguo le route; se dal mio form volgio inviare 
    dei files devo utlizzare l'attributo "enctype" con valore "multiform/form-data".
Il progetto esiste in entrambi i casi, con exists controllo se ha l'id vado a modificarlo, 
se no significa che sono sulla create --}}
@if ($project->exists)
    <form class="row g-3" action="{{ route('admin.projects.update', $project->id) }}" method="POST"
        enctype="multipart/form-data" novalidate>
        @method('PUT')
    @else
        <form class="row g-3" action="{{ route('admin.projects.store') }}" method="POST" enctype="multipart/form-data"
            novalidate>
@endif

@csrf
<div class="row">
    <div class="col-md-5">
        <label for="name" class="form-label">Name</label>
        <input type="text" class="form-control" id="name" name="name"
            value="{{ old('name', $project->name) }}" required>
    </div>
    <div class="col-md-4">
        <label for="image" class="form-label">Image</label>
        @if ($project->image)
            <button type="button" id="btn-change"
                class="form-control btn btn-outline-primary justify-content-end align-items-center d-block">Cambia
                Immagine</button>

                <input type="file" class="form-control d-none image" name="image">
        @else
            <input type="file" class="form-control image" name="image">
        @endif
    </div>
    <div class="col-md-1">
        <img class="img-fluid" id="preview"
            src="{{ $project->image ? asset('storage/' . $project->image) : 'https://marcolanci.it/utils/placeholder.jpg' }}"
            alt="{{ $project->name }}">
    </div>
    <div class="col-md-2">
        <label for="type_id" class="form-label">Type</label>
        <select class="form-select" name="type_id" id="type_id">
            <option value="">Nothing selected</option>
            @foreach ($types as $type)
                {{-- giro sull'array types, mantengo il valore selezionato con old in caso di errore 
                e assegno l'attributo selected all'option che l'id che corrisponde al type_id della tabella Projects --}}
                <option @if (old('type_id', $project->type_id) == $type->id) selected @endif value="{{ $type->id }}">
                    {{ $type->label }}</option>
            @endforeach
        </select>
    </div>
</div>

<div class="mb-3">
    <label for="description" class="form-label">Description</label>
    <textarea class="form-control" id="description" rows="3" name="description">{{ old('description', $project->description) }}</textarea>
</div>
<div class="mb-3">
    <label for="web_platform" class="form-label">Web platform</label>
    <textarea class="form-control" id="web_platform" rows="3" name="web_platform">{{ old('web_platform', $project->web_platform) }}</textarea>
</div>

<div class="row justify-content-end">
    <div class="col-md-6">
        <label for="project_for" class="form-label">Project_for</label>
        <input type="text" class="form-control" id="project_for" name="project_for"
            value="{{ old('project_for', $project->project_for) }}">
    </div>
    <div class="col-md-6">
        <label for="duration_project" class="form-label">Duration_project</label>
        <input type="text" class="form-control" id="duration_project" name="duration_project"
            value="{{ old('duration_project', $project->duration_project) }}">
    </div>
</div>

<div class="row mt-3">
    <div class="col-6 d-flex">
        @foreach ($technologies as $technology )
        <div class="form-check">
            {{-- Uso di un prefisso nell'id dell'input e nel for del label per distiguere il checkbox da altri che potrei inserire --}}
            <input class="form-check-input" type="checkbox" id="technology-{{ $technology->id }}" value="{{ $technology->id }}" name="technologies[]" 
            
            {{-- Con l'attributo checked distiguiamo il form della pagina create da quella dell'edit 
            Con in_array conrolliamo se l'id del singolo checkbox è presente nell'array, secondo parametro in quale array lo cerchiamo
            Se invio un form e ho degli errori, rimangono checkati i valori selezionati; se invece entro in una pagina di modifica di un progetto
            trovo selezionati i checkbox dell'array project_technologies che corrispondono a quelli dell'ultima modifica 
            Terza ipotesi, entro in una pagina per creare un nuovo progetto (nella create) guardo in array vuoto, situazione di tutti checkbox non selezionati--}}
            @if(in_array($technology->id, old('technologies', $project_technologies ?? []))) checked @endif>


            <label class="form-check-label me-3" for="technology-{{ $technology->id }}"> 
              {{ $technology->label }}
            </label>
        </div>
        @endforeach
   
    </div>
    
    <div class="col-6 d-flex justify-content-end">
        <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" role="switch" id="is_published" name="is_published" @if(old('is_published', $project->is_published)) checked @endif>
            <label class="form-check-label" for="is_published">Pubblicato</label>
        </div>
    </div>
</div>
    

<div class="d-flex justify-content-end">
    <a href="{{ route('admin.projects.index') }}" class="btn btn-secondary me-2 px-4 py-2">Back</a>
    <button type="submit" class="btn btn-success px-4 py-2">Salva</button>

</div>


</form>



@section('scripts')
    <script>
        const placeholder = 'https://marcolanci.it/utils/placeholder.jpg';

        // Recupero gli elementi da dom
        const imageFile = document.querySelector('.image');
        const imagePreview = document.getElementById('preview');

        // Aggancio un event listener all'input
        imageFile.addEventListener('change', () => {
            // Controllo se ho caricato un file
            if (imageFile.files && imageFile.files[0]) {

                // istanzio un oggetto per leggere il contenuto dei file con fileReader
                const reader = new FileReader();

                // metodo per leggere il file come url, gli passo il file caricato 
                reader.readAsDataURL(imageFile.files[0]);

                // quando è stato preparato il file da leggere
                reader.onload = e => {
                    // prendo l'src dell'imagePreview e gli assegno il risultato della lettura del file
                    // image.Preview.setAttribute('src', placeholder);
                    imagePreview.src = e.target.result;
                }

            } else imagePreview.src = placeholder;
        });
    </script>

    <script>
        const buttonChange = document.getElementById('btn-change')
        const imageChange = document.querySelector('.image');

        buttonChange.addEventListener('click', () => {
            buttonChange.classList.remove('d-block');
            buttonChange.classList.add('d-none');
            imageChange.classList.remove('d-none');
            imageChange.classList.add('d-block');

        });
    </script>
@endsection
