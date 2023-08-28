@props(['event'])

@can('events.manage')
<nav class="mb-3 navbar navbar-expand navbar-light bg-white py-0 border-bottom">
    <div class="navbar-nav me-auto">
        <a href="{{route('indexSubscribers', $event->id)}}" class="nav-item nav-link">Ver inscrições</a>
        <a href="{{route('indexEventSubmissions', $event->id)}}" class="nav-item nav-link">Ver submissões</a>
        @role('admin')
            <a href="{{route('createModerator', $event->id)}}" class="nav-item nav-link">Adicionar moderadores</a>
        @endif
        <a href="{{ route('editEvent', $event->id)}}" class="nav-item nav-link">Editar evento</a>
        @can('events.delete')
            <button class="nav-item nav-link btn" data-bs-toggle="modal" data-bs-target="#eventDeletePrompt{{$event->id}}">Excluir evento</button>
        @endcan
    </div>
</nav>
@else
<nav class="mb-3 navbar navbar-expand navbar-light bg-white py-0 border-bottom">
    <div class="navbar-nav me-auto">
        <a href="{{route('indexEventSubmissions', $event->id)}}" class="nav-item nav-link">Ver submissões</a>
    </div>
</nav>
@endcan
