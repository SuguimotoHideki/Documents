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
                @if($event->hasUser())
                    <div class="row">
                        <div class="text-muted">Inscrição nº: {{$event->subscriptionData(Auth::user())['id']}}</div>
                        <div class="text-muted">Inscrito em: {{$event->subscriptionData(Auth::user())['created_at']}}</div>
                    </div>
                @endif
                @can('manage any event')
                <nav class="mb-3 navbar navbar-expand navbar-light bg-white py-0 border-bottom">
                    <div class="navbar-nav me-auto">
                        <a href="{{route('indexSubscribers', $event->id)}}" class="nav-item nav-link">Ver inscrições</a>
                        <a href="{{ route('editEvent', $event->id)}}" class="nav-item nav-link">Editar evento</a>
                        <button class="nav-item nav-link btn" data-bs-toggle="modal" data-bs-target="#eventDeletePrompt{{$event->id}}">Excluir evento</button>
                    </div>
                </nav>
                @endcan
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
                    @if($event->hasUser())
                        <div class="row">
                            <div class="d-grid col-4 mx-auto">
                                <button type="button" class="btn btn-dark" disabled>
                                    Inscrito
                                </button>
                            </div>
                            <div class="d-grid col-4 mx-auto">
                                <a href="{{route('createDocument')}}" class="btn btn-primary">
                                    Submeter artigo
                                </a>
                            </div>
                        </div>
                    @else
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#subscriptionPrompt">
                            Inscrever-se
                        </button>
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
                <p>Deseja se inscrever em {{$event->event_name}} ?</p>
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
            <p>Deseja excluir o evento {{$event->event_name}} ?</p>
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
