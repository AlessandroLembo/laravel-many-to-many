@extends('layouts.app')

@section('title', 'Technologies')

@section('content')
    <header>
        <div class="d-flex align-items-center justify-content-around">
            <h1 class="text-center my-5 fs-1">Technologies</h1>
            <a href="{{ route('admin.technologies.create') }}" class="btn btn-success">Crea nuova</a>
        </div>
    </header>
       
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">label</th>
                    <th scope="col">Crato il</th>
                    <th scope="col">Aggiornato il</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($technologies as $technology)
                    <tr>
                        <th scope="row">{{ $technology->id }}</th>
                        <td>{{ $technology->label }}</td>
                        <td>{{ $technology->created_at }}</td>
                        <td>{{ $technology->updated_at }}</td>
                        <td>
                            <div class="d-flex justify-content-end align-items-center">
                        
                                <a class="btn btn-sm btn-warning ms-2" href="{{ route('admin.technologies.edit', $technology->id) }}">
                                    <i class="fa-solid fa-pen-to-square"></i></a>
    
                                <form action="{{ route('admin.technologies.destroy', $technology->id) }}" method="POST"
                                    class="delete-form" data-entity="tipo">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger ms-2"><i
                                            class="fa-solid fa-trash"></i></button>
                                </form>
                            </div>
                        </td>
                               
                    </tr>
                @empty
                    <tr>
                        <th scope="row" colspan="6" class="text-center">Non ci sono elementi</td>
                    </tr>
                @endforelse

            </tbody>
        </table>

        <div class="d-flex justify-content-end">
            <a href="{{ route('admin.projects.index') }}" class="btn btn-secondary me-2 px-4 py-2">Back</a>    
        </div>

        <div class="d-flex justify-content-end mt-3">
            {{-- Stampo il paginatore --}}
            {{ $technologies->links() }}
        </div>

        
@endsection
