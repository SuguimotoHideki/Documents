@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">

        <div class="row justify-content-center">
            <div class="col-md-4"></div>
            <div class="col-md-4">
                <h1 class="fs-3 fw-bold text-uppercase text-center mb-3">{{$event->event_name}}</h1>
            </div>
            <div class="col-md-4 float-right">
                <a href="{{ url()->previous()}}" class="btn btn-outline-dark float-end"><i class="fa-solid fa-arrow-left"></i> Página anterior</a>

            </div>
        </div>

        <div class="col-md-9">
            <div class="shadow-sm p-3 mb-5 bg-white">
                <x-event-nav-menu :event="$event"/>
                @if($event->hasUser(Auth::user()))
                    <div class="row">
                        <div class="text-muted">Inscrição nº: {{$subscription->id}}</div>
                        <div class="text-muted">Inscrito em: {{$event->formatDateTime($subscription->created_at)}}</div>
                    </div>
                @endif
                <div class="mt-3 text-break">
                    <h2 class="fs-5 fw-bold text-start">Sobre o evento:</h2>
                    <div>{{$event->event_information}}</div>
                </div>
                <div class="row">
                    <div class="col-md">
                        <div class="mt-3">
                            <h2 class="fs-5 fw-bold">Site do evento:</h2>
                            <div>{{$event->event_website}}</div>
                        </div>
                        <div class="mt-3">
                            <h2 class="fs-5 fw-bold">Email do evento:</h2>
                            <div>{{$event->event_email}}</div>
                        </div>

                    </div>
                    <div class="col-md">
                        <div class="mt-3">
                            <h2 class="fs-5 fw-bold">Tópicos de artigos:</h2>
                            <x-list-items : wordList="{{$event->paper_topics}}"/>
                        </div>
                    </div>
                </div>
                <div class="mt-5 text-center">
                    @if($event->hasUser(Auth::user()))
                        <div class="row">
                            <div class="d-grid col-4 mx-auto">
                                <button type="button" class="btn btn-dark" disabled>
                                    Inscrito
                                </button>
                            </div>
                            <div class="d-grid col-4 mx-auto">
                                @if (Auth::user()->events->contains($event) && Auth::user()->submission()->where('event_id', $event->id)->exists())
                                <button type="button" class="btn btn-dark" disabled>
                                    Submissão realizada
                                </button>
                                @else
                                <a href="{{route('createDocument', $event)}}" class="btn btn-primary">
                                    Submeter artigo
                                </a>
                                @endif
                            </div>
                        </div>
                    @else
                        @if($event->event_status > 2)
                            <button type="button" class="btn btn-dark" disabled>
                                Inscrições encerradas
                            </button>
                        @else
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#subscriptionPrompt">
                                Inscrever-se
                            </button>
                        @endif
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="shadow-sm p-3 mb-3 bg-white">
                <div>
                    <h2 class="fs-5 fw-bold mt-3">
                        <i class="fa-regular fa-clock"></i> Período de inscrição:</h2>
                    <div class="mt-2">Inicio: {{$event->formatDate($event->subscription_start)}}</div>
                    <div class="mt-2">Fim: {{$event->formatDate($event->subscription_deadline)}}</div>
                </div>
            </div>
            <div class="shadow-sm p-3 mb-3 bg-white">
                <div>
                    <h2 class="fs-5 fw-bold mt-3">
                        <i class="fa-regular fa-clock"></i> Período de submissão:</h2>
                    <div class="mt-2">Inicio: {{$event->formatDate($event->submission_start)}}</div>
                    <div class="mt-2">Fim: {{$event->formatDate($event->submission_deadline)}}</div>
                </div>
            </div>
            <div class="shadow-sm p-3 mb-3 bg-white">
                <div>
                    <h2 class="fs-5 fw-bold mt-2">Organizador:</h2>
                        <div>
                            <div>{{$event->organizer}}</div>
                        </div>
                        <div class="mt-2">

                            <div>Website: {{$event->organizer_website}}</div>
                        </div>
                        <div class="mt-2">
                            <div>Email: {{$event->organizer_email}}</div>
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
                <h5 class="modal-title">{{$event->event_name}}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Deseja se inscrever em <strong>{{$event->event_name}}</strong> ?</p>
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
            <p>Deseja excluir o evento <strong>{{$event->event_name}}</strong> ?</p>
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
