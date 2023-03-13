@if (session('message'))
    {{-- visualizza il messaggio che conferma la conclusione dell'operazione effettuata --}}
    <div class="alert alert-{{ session('type') ?? 'info' }} mt-5">
        {{ session('message') }}
    </div>
@endif
