@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="list-group - list-group-flush shadow-sm p-3 mb-5 bg-white">
                <h1 class="fs-3 fw-bold text-uppercase">{{$event->event_name}}</h1>

                <div class="mt-3 text-break">
                    <h2 class="fs-5 fw-bold text-start">Sobre o evento:</h2>
                    <div>{{$event->event_information}}</div>
                </div>
                <div class="mt-3">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#subscriptionPrompt">
                        Inscrever-se
                    </button>
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
                </div>

                <hr>
                <div class="row">
                    <div class="col-md">
                        <div>
                            <h2 class="fs-5 fw-bold">Site do evento:</h2>
                            <div>{{$event->event_website}}</div>
                        </div>
                        <div class="mt-3">
                            <h2 class="fs-5 fw-bold">Email do evento:</h2>
                            <div>{{$event->event_email}}</div>
                        </div>
                        <div class="mt-3">
                            <h2 class="fs-5 fw-bold">Prazo para inscrição:</h2>
                            <ul class="mb-0">
                                <li>Inicio: {{$event->formatDate($event->subscription_start)}}</li>
                                <li>Fim: {{$event->formatDate($event->subscription_deadline)}}</li>
                            </ul>
                        </div>
                        <div class="mt-3">
                            <h2 class="fs-5 fw-bold">Prazo para submissão:</h2>
                            <ul class="mb-0">
                                <li>Inicio: {{$event->formatDate($event->submission_start)}}</li>
                                <li>Fim: {{$event->formatDate($event->submission_deadline)}}</li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md">
                        <div>
                            <h2 class="fs-5 fw-bold">Organizador:</h2>
                            <div>{{$event->organizer}}</div>
                        </div>
                        <div class="mt-3">
                            <h2 class="fs-5 fw-bold">Site do organizador:</h2>
                            <div>{{$event->organizer_website}}</div>
                        </div>
                        <div class="mt-3">
                            <h2 class="fs-5 fw-bold">Email do organizador:</h2>
                            <div>{{$event->organizer_email}}</div>
                        </div>
                        <div class="mt-3">
                            <h2 class="fs-5 fw-bold">Tópicos de artigos:</h2>
                            <x-list-items : wordList="{{$event->paper_topics}}"/>
                        </div>
                    </div>
                </div>

                <!--
                <div class="mt-3">
                    <div class="fw-bold">Trilha de artigos:</div>
                    <x-list-items : wordList="{{$event->paper_tracks}}"/>
                </div>-->
            </div>
        </div>
    </div>
</div>
@endsection
