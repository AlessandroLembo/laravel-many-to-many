@extends('layouts.app')

@section('title', $project->name)

@section('content')
    <header class="text-center my-5 fs-1 fw-bold">{{ $project->name }}</header>
    <div class="row justify-content-center">
        <div class="col-6">
            @if ($project->image)
                <figure class="d-flex justify-content-center">
                    <img src="{{ asset('storage/' . $project->image) }}" alt="{{ $project->name }}" class="ps-image-project">

                </figure>
            @endif

        </div>
        <div class="col-6">
            <div class="d-flex flex-column align-items-start">
                <h2>{{ $project->slug }}</h2>
                <p>{{ $project->description }}</p>
                <p class="fs-4"><strong>Progetto per:</strong> {{ $project->project_for }}</p>
                @if ($project->type?->label)
                   <p class="fs-4"><strong>Tipo progetto:</strong> {{ $project->type?->label }}</p>
                @endif   
                <p class="fs-4"><strong>Stato:</strong> {{ $project->is_published ? 'Pubblicato' : 'Bozza' }}</p>
                <p class="fs-4"><strong>Pubblicato su:</strong> {{ $project->web_platform }}</p>
                <p class="fs-4"><strong>Durata del progetto:</strong> {{ $project->duration_project }}</p>
            </div>
        </div>

    </div>
    <hr>
    <div class="d-flex justify-content-between align-items-center">
        <form action="{{ route('admin.projects.toggle', $project->id) }}" method="POST">
          @method('PATCH')
          @csrf
  
          <button type="submit" class="btn me-2 btn-outline-{{ $project->is_published ? 'danger' : 'success' }}">
            {{ $project->is_published ? 'Metti in bozze' : 'Pubblica' }}
          </button>
        </form>
    
        <div class="d-flex justify-content-end align-items-center">
          <form action="{{ route('admin.projects.destroy', $project->id) }}" method="POST" class="delete-form"
            data-entity="progetto">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger me-2"><i class="fa-solid fa-trash me-2"></i>Elimina</button>
          </form>
          <a class="btn btn-warning me-2" href="{{ route('admin.projects.edit', $project->id) }}">
            <i class="fa-solid fa-pen-to-square me-2"></i>Modifica</a>
          <a class="btn btn-secondary" href="{{ route('admin.projects.index') }}"><i
                class="fa-solid fa-square-caret-left me-2"></i>BACK</a>
       </div>
    </div>
@endsection
