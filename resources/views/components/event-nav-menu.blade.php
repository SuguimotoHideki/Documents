@props(['event'])

@role('user')
    @if($event->hasUser(Auth::user()))
        @if($event->userSubmission(Auth::user()) !== null)
            <div class="col-md-3">
                <div class="shadow-sm p-3 mb-5 bg-white h-100">
                    <h2 class="fw-bold fs-4 pb-2 border-bottom">Evento</h2>
                    <ul class="nav flex-column mb-auto">
                        <li class="mb-2">
                            <a href="{{route('showDocument', $event->userSubmission(Auth::user())->document)}}" class="btn btn-light w-100 py-2 text-start">
                                <i class="fa-regular fa-file"></i> Ver submissão
                            </a>
                        </li>
                        <li class="mb-2">
                            <a href="{{route('editDocument', $event->userSubmission(Auth::user())->document)}}" class="btn btn-light w-100 py-2 text-start">
                                <i class="fa-regular fa-pen-to-square"></i> Editar submissão
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        @endif
    @endif
@endif

@can('events.manage')
<div class="col-md-3">
    <div class="shadow-sm p-3 mb-5 bg-white h-100">
        <div class="fw-bold fs-4 mb-2 border-bottom">
            <a href="{{route('showEvent', $event)}}">Gerenciar</a>
        </div>
        <ul class="nav flex-column mb-auto">
            <li class="mb-2">
                <a href="{{route('editEvent', $event)}}" class="btn btn-light w-100 py-2 text-start" aria-pressed="true">
                    <i class="fa-regular fa-pen-to-square"></i> Editar evento
                </a>
            </li>
            <li class="mb-2">
                <a href="{{route('indexSubscribers', $event)}}" class="btn btn-light w-100 py-2 text-start">
                    <i class="fa-solid fa-user"></i> Ver inscrições
                </a>
            </li>
            <li class="mb-2">
                <a href="{{route('indexEventSubmissions', $event)}}" class="btn btn-light w-100 py-2 text-start">
                    <i class="fa-regular fa-file"></i> Ver submissões
                </a>
            </li>
            @role('admin')
                <li class="mb-2">
                    <a href="{{route('createModerator', $event)}}" class="btn btn-light w-100 py-2 text-start">
                        <i class="fa-regular fa-pen-to-square"></i> Gerenciar moderadores
                    </a>
                </li>
                <li class="mb-2">
                    <a data-bs-toggle="modal" data-bs-target="#eventDeletePrompt{{$event->id}}" class="btn btn-light w-100 py-2 text-start">
                        <i class="fa-solid fa-trash-can"></i> Excluir evento
                    </a>
                </li>
            @endrole
        </ul>
    </div>
</div>
@endcan

<div class="modal fade" id="eventDeletePrompt{{$event->id}}" tabindex="-1" aria-labelledby="eventDeletePromptLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Excluir evento</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <p>Deseja excluir o evento <strong>{{$event->name}}</strong> ?</p>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            <form action="{{ route('deleteEvent', $event->id)}}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">
                    {{ __('Excluir') }}
                </button>
            </form>
        </div>
        </div>
    </div>
</div>