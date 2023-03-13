@if ($type->exists)
    <form class="row g-3" action="{{ route('admin.types.update', $type->id) }}" method="POST"
        enctype="multipart/form-data" novalidate>
        @method('PUT')
    @else
        <form class="row g-3" action="{{ route('admin.types.store') }}" method="POST" enctype="multipart/form-data"
            novalidate>
@endif

<form class="row g-3" action="{{ route('admin.projects.store') }}" method="POST">
@csrf
<div class="row">
    <div class="col-md-10">
        <label for="label" class="form-label">Label</label>
        <input type="text" class="form-control" id="label" name="label"
            value="{{ old('label', $type->label) }}" required maxlength="15">
    </div>
    <div class="col-md-2">
        <label for="color" class="form-label">Colore</label>
        <input type="color" class="form-control" id="color" name="color"
            value="{{ old('color', $type->color) }}">
    </div>
   
</div>    

<div class="d-flex">
    <a href="{{ route('admin.types.index') }}" class="btn btn-secondary me-2 px-4 py-2">Back</a>
    <button type="submit" class="btn btn-success px-4 py-2">Salva</button>

</div>

</form>

