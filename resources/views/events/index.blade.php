@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <h1 class='fs-2'>Eventos abertos</h1>
            <div class="list-group list-group-flush shadow-sm p-3 mb-5 bg-white">
                <div class="table-responsive">
                    <table class="table bg-white">
                        <colgroup>
                            <col width="20%">
                            <col width="10%">
                            <col width="10%">
                            <col width ="20%">
                            <col width ="20%">
                            <col width ="10%">
                        </colgroup>
                        <thead>
                            <tr>
                                <th id="t1">Evento</th>
                                <th id="t3">Site oficial do evento</th>
                                <th id="t2">Email do evento</th>
                                <th id="t4">Prazo para inscrição</th>
                                <th id="t5">Prazo para submissão</th>
                                <th id="t6">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($events as $event)
                            <tr>
                                <td headers="t1"><a href="events/{{$event->id}}">{{$event->event_name}}</a></td>
                                <td headers="t2">{{$event->event_website}}</td>
                                <td headers="t3">{{$event->event_email}}</td>
                                <td headers="t4">{{$event->formatDate($event->subscription_start)}} - {{$event->formatDate($event->subscription_deadline)}}</td>
                                <td headers="t5">{{$event->formatDate($event->submission_start)}} - {{$event->formatDate($event->submission_deadline)}}</td>
                                <td headers="t6">{{$event->updateStatus($event->event_status)}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
