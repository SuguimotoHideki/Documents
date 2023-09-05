@props(['document'])

@role(['admin', 'event moderator'])
<nav class="mb-3 navbar navbar-expand navbar-light bg-white py-0 border-bottom">
    <div class="navbar-nav me-auto">
        <a href="{{route('editDocument', $document->id)}}" class="nav-item nav-link">Editar submissão</a>
        <a href="{{ route('indexByDocument', $document->id)}}" class="nav-item nav-link">Ver avaliações</a>
        <a href="{{route('assignReviewer', $document->id)}}" class="nav-item nav-link">Adicionar avaliadores</a>
    </div>
</nav>
@elseif(Auth::user()->hasRole('reviewer') && Auth::user()->isModerator($event))
<nav class="mb-3 navbar navbar-expand navbar-light bg-white py-0 border-bottom">
    <div class="navbar-nav me-auto">
        <a href="{{route('indexSubscribers', $event->id)}}" class="nav-item nav-link">Ver inscrições</a>
        <a href="{{route('indexEventSubmissions', $event->id)}}" class="nav-item nav-link">Ver submissões</a>
        <a href="{{ route('editEvent', $event->id)}}" class="nav-item nav-link">Editar evento</a>
    </div>
</nav>
@elseif(Auth::user()->hasRole('user'))
<nav class="mb-3 navbar navbar-expand navbar-light bg-white py-0 border-bottom">
    <div class="navbar-nav me-auto">
        <a href="{{ route('editDocument', $document->id)}}" class="nav-item nav-link">Editar submissão</a>
        <a href="{{ route('indexByDocument', $document->id)}}" class="nav-item nav-link">Ver avaliações</a>
    </div>
</nav>
@endcan