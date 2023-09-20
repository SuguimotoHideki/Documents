@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="shadow-sm p-3 mb-5 bg-white">
                <x-event-nav-menu :event="$event"/>
                <div class="row">
                    <div class="col-md-4">
                        <img class="logo mb-3" src="{{asset('storage/'.$event->logo)}}" alt="Logo do evento" width="100%"/>
                        <div class="mb-3">
                            <div class="text-muted">{{"Organizador: $event->organizer"}}</div>
                            <div class="text-muted">
                                <i class="fa-solid fa-link"></i> Website: <a href="{{$event->organizer_website}}">{{$event->organizer_website}}</a>
                            </div>
                            <div class="text-muted">
                                <i class="fa-solid fa-envelope"></i> Website: <a href="mailto:{{$event->organizer_email}}">{{$event->organizer_email}}</a>
                            </div>
                        </div>
                        <div class="text-center">
                            @if($event->hasUser(Auth::user()))
                                <button type="button" class="btn btn-dark width-100 mb-3" disabled>
                                    Inscrito
                                </button>
                                @if (Auth::user()->events->contains($event) && Auth::user()->submission()->where('event_id', $event->id)->exists())
                                    <a href="{{route('showDocument', $event->userSubmission(Auth::user())->document)}}" class="btn btn-primary width-100 mb-3">Ver submissão</a>
                                @else
                                    @if($event->getStatusID() < 3)
                                        <a class="btn btn-primary width-100 mb-3 disabled">
                                            Submissões em breve
                                        </a>
                                    @elseif($event->getStatusID() === 3)
                                        <a href="{{route('createDocument', $event)}}" class="btn btn-primary width-100 mb-3">
                                            Submeter artigo
                                        </a>
                                    @else
                                        <a class="btn btn-primary width-100 mb-3 disabled">
                                            Submissões encerradas
                                        </a>
                                    @endif
                                @endif
                            @else
                                @if($event->status > 2)
                                    <button type="button" class="btn btn-dark width-100 mb-3" disabled>
                                        Inscrições encerradas
                                    </button>
                                @else
                                    <button type="button" class="btn btn-primary width-100 mb-3" data-bs-toggle="modal" data-bs-target="#subscriptionPrompt">
                                        Inscrever-se
                                    </button>
                                @endif
                            @endif
                        </div>
                    </div>
                    <div class="col-md-8">
                        <h1 class="fs-5 text-start">
                            {{$event->name}}
                        </h1>
                        <div class="text-muted">Inscrições: {{$event->getSubscriptionDates()}}</div>
                        <div class="text-muted">Submissões: {{$event->getSubmissionDates()}}</div>
                        <div class="text-paragraph text-muted mt-2">{{$event->information}}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="subscriptionPrompt" tabindex="-1" aria-labelledby="subscriptionPromptLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{$event->name}}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Deseja se inscrever em <strong>{{$event->name}}</strong> ?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <form action="{{ route('eventSubscribe', $event)}}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-primary">
                        {{ __('Confirmar inscrição') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

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

@endsection
