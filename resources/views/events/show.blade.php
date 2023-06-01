@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="list-group - list-group-flush shadow-sm p-3 mb-5 bg-white">
                <div class="text-xl uppercase fw-bold">{{$event->event_name}}</div>
                <div class="row">
                    <div class="col-md">
                        <div class="mt-3">
                            <div class="fw-bold">Site do evento:</div>
                            <div>{{$event->event_website}}</div>
                        </div>
                        <div class="mt-3">
                            <div class="fw-bold">Email do evento:</div>
                            <div>{{$event->event_email}}</div>
                        </div>
                        <div class="mt-3">
                            <div class="fw-bold">Realização:</div>
                            <div>{{$event->formatDate($event->event_start)}} - {{$event->formatDate($event->event_end)}}</div>
                        </div>
                        <div class="mt-3">
                            <div class="fw-bold">Prazo para inscrição:</div>
                            <div>{{$event->formatDate($event->subscription_deadline)}}</div>
                        </div>
                        <div class="mt-3">
                            <div class="fw-bold">Prazo para submissão:</div>
                            <div>{{$event->formatDate($event->submission_deadline)}}</div>
                        </div>
                    </div>
                    <div class="col-md">
                        <div class="mt-3">
                            <div class="fw-bold">Organizador:</div>
                            <div>{{$event->organizer}}</div>
                        </div>
                        <div class="mt-3">
                            <div class="fw-bold">Site do organizador:</div>
                            <div>{{$event->organizer_website}}</div>
                        </div>
                        <div class="mt-3">
                            <div class="fw-bold">Email do organizador:</div>
                            <div>{{$event->organizer_email}}</div>
                        </div>
                    </div>
                </div>
                <div class="mt-3">
                    <div class="fw-bold">Sobre o evento:</div>
                    <div>{{$event->event_information}}</div>
                </div>
                <div class="mt-3">
                    <div class="fw-bold">Tópicos de artigos:</div>
                    <x-list-items : wordList="{{$event->paper_topics}}"/>
                </div>
                <div class="mt-3">
                    <div class="fw-bold">Trilha de artigos:</div>
                    <x-list-items : wordList="{{$event->paper_tracks}}"/>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
