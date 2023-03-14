@if ($technology->exists)
    <form class="row g-3" action="{{ route('admin.technologies.update', $technology->id) }}" method="POST"
        enctype="multipart/form-data" novalidate>
        @method('PUT')
    @else
        <form class="row g-3" action="{{ route('admin.technologies.store') }}" method="POST" enctype="multipart/form-data"
            novalidate>
@endif

{{-- <form class="row g-3" action="{{ route('admin.projects.store') }}" method="POST"> --}}
@csrf
<div class="row">
    <div class="col-md-10">
        <label for="label" class="form-label">Label</label>
        <input type="text" class="form-control" id="label" name="label"
            value="{{ old('label', $technology->label) }}" required maxlength="15">
    </div>
    <div class="col-md-2">
        <label for="color" class="form-label">Colore</label>
        <input type="text" class="form-control" id="color" name="color"
            value="{{ old('color', $technology->color) }}">
    </div>
   
</div>    

<div class="d-flex">
    <a href="{{ route('admin.technologies.index') }}" class="btn btn-secondary me-2 px-4 py-2">Back</a>
    <button type="submit" class="btn btn-success px-4 py-2">Salva</button>

</div>

</form>

