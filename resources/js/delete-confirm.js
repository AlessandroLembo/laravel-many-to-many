const deleteForms = document.querySelectorAll('.delete-form');
deleteForms.forEach(form => {
    form.addEventListener('submit', event => {
        // blocco l'invio del form con prevent default
        event.preventDefault()

        // rendo dinamico il soggetto del messaggio
        const element = form.getAttribute('data-entity') || 'elemento';

        // funzione confirm() che chiede la conferma dell'eliminazione
        const hasConfirmed = confirm(`Confermi di voler cancellare il ${element}?`)

        // Se mi conferma eseguo l'eleiminazione definitiva
        if (hasConfirmed) form.submit();
    })
})
    
