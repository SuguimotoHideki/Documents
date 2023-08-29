@props(['event'])

@role('admin')
<nav class="mb-3 navbar navbar-expand navbar-light bg-white py-0 border-bottom">
    <div class="navbar-nav me-auto">
        <a href="{{route('indexSubscribers', $event->id)}}" class="nav-item nav-link">Ver inscrições</a>
        <a href="{{route('indexEventSubmissions', $event->id)}}" class="nav-item nav-link">Ver submissões</a>
        <a href="{{route('createModerator', $event->id)}}" class="nav-item nav-link">Adicionar moderadores</a>
        <a href="{{ route('editEvent', $event->id)}}" class="nav-item nav-link">Editar evento</a>
        <button class="nav-item nav-link btn" data-bs-toggle="modal" data-bs-target="#eventDeletePrompt{{$event->id}}">Excluir evento</button>
    </div>
</nav>
@elseif(Auth::user()->hasRole('event moderator') && Auth::user()->isModerator($event))
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
        <a href="{{route('showDocument', $event->userSubmission(Auth::user()))}}" class="nav-item nav-link">Ver submissão</a>
    </div>
</nav>
@endcan
