@props(['event'])

@role('user')
    @if($event->userSubmission(Auth::user()) !== null)
        <nav class="mb-3 navbar navbar-expand navbar-light bg-white py-0 border-bottom">
            <div class="navbar-nav me-auto">
                <a href="{{route('showDocument', $event->userSubmission(Auth::user())->document)}}" class="nav-item nav-link">Ver submissão</a>
                <a href="{{route('editDocument', $event->userSubmission(Auth::user())->document)}}" class="nav-item nav-link">Editar submissão</a>
            </div>
        </nav>
    @endif
@endif
@can(['events.manage'])
    <nav class="mb-3 navbar navbar-expand navbar-light bg-white py-0 border-bottom">
        <div class="navbar-nav me-auto">
            <a href="{{ route('editEvent', $event->id)}}" class="nav-item nav-link">Editar evento</a>
            <a href="{{route('indexSubscribers', $event->id)}}" class="nav-item nav-link">Ver inscrições</a>
            <a href="{{route('indexEventSubmissions', $event->id)}}" class="nav-item nav-link">Ver submissões</a>
            @role('admin')
                <a href="{{route('createModerator', $event->id)}}" class="nav-item nav-link">Adicionar moderadores</a>
                <a href="#" class="nav-item nav-link" data-bs-toggle="modal" data-bs-target="#eventDeletePrompt{{$event->id}}">Excluir evento</a>
            @endif
        </div>
    </nav>
@endcan