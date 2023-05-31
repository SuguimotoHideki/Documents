@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="list-group - list-group-flush shadow-sm p-3 mb-5 bg-white">
                <div class="row">
                    <span class="text-xl uppercase fw-bold">{{$event->event_name}}</span>
                </div>
                <div class="row">
                    <div class="col-md">
                        <div class="mt-3">
                            <div>
                                <span class="fw-bold">Site do evento:</span>
                            </div>
                            <div>
                                <span>{{$event->event_website}}</span>
                            </div>
                        </div>
                        <div class="mt-3">
                            <div>
                                <span class="fw-bold">Email do evento:</span>
                            </div>
                            <div>
                                <span>{{$event->event_email}}</span>
                            </div>
                        </div>
                        <div class="mt-3">
                            <div>
                                <span class="fw-bold">Realização:</span>
                            </div>
                            <div>
                                <span>{{$event->formatDate($event->event_start)}} - {{$event->formatDate($event->event_end)}}</span>
                            </div>
                        </div>
                        <div class="mt-3">
                            <div>
                                <span class="fw-bold">Prazo para inscrição:</span>
                            </div>
                            <div>
                                <span>{{$event->formatDate($event->subscription_deadline)}}</span>
                            </div>
                        </div>
                        <div class="mt-3">
                            <div>
                                <span class="fw-bold">Prazo para submissão:</span>
                            </div>
                            <div>
                                <span>{{$event->formatDate($event->submission_deadline)}}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md">
                        <div class="mt-3">
                            <div>
                                <span class="fw-bold">Organizador:</span>
                            </div>
                            <div>
                                <span>{{$event->organizer}}</span>
                            </div>
                        </div>
                        <div class="mt-3">
                            <div>
                                <span class="fw-bold">Site do organizador:</span>
                            </div>
                            <div>
                                <span>{{$event->organizer_website}}</span>
                            </div>
                        </div>
                        <div class="mt-3">
                            <div>
                                <span class="fw-bold">Email do organizador:</span>
                            </div>
                            <div>
                                <span>{{$event->organizer_email}}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-3">
                    <div>
                        <span class="fw-bold">Sobre o evento:</span>
                    </div>
                    <div>
                        <span>{{$event->event_information}}</span>
                    </div>
                </div>
                <div class="mt-3">
                    <div>
                        <span class="fw-bold">Tópicos de artigos:</span>
                    </div>
                    <ul class="mb-0">
                        @foreach (explode(',', $event->paper_topics) as $topics)
                            <li>
                                <span>{{$topics}}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <div class="mt-3">
                    <div>
                        <span class="fw-bold">Trilha de artigos:</span>
                    </div>
                    <ul class="mb-0">
                        @foreach (explode(',', $event->paper_tracks) as $tracks)
                            <li>
                                <span>{{$tracks}}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
