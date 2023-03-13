{{-- se c'è almeno un errore --}}
@if ($errors->any())
    <div class="alert alert-danger my-5">
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </div>
@endif
