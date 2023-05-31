@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="list-group list-group-flush shadow-sm p-3 mb-5 bg-white">
                <div class="table-responsive">
                    <table class="table bg-white">
                        <colgroup>
                            <col width="20%">
                            <col width="20%">
                            <col width="20%">
                            <col width ="10%">
                            <col width ="10%">
                            <col width ="20%">
                        </colgroup>
                        <tr>
                            <th id="t1">Evento</th>
                            <th id="t3">Site oficial do evento</th>
                            <th id="t2">Email do evento</th>
                            <th id="t4">Prazo para inscrição</th>
                            <th id="t5">Prazo para submissão</th>
                            <th id="t6">Status</th>
                        </tr>
                        <tr>
                            @foreach($events as $event)
                            <td headers="t1"><a href="events/{{$event->id}}">{{$event->event_name}}</a></td>
                            <td headers="t2">{{$event->event_website}}</td>
                            <td headers="t3">{{$event->event_email}}</td>
                            <td headers="t4">{{$event->formatDate($event->subscription_deadline)}}</td>
                            <td headers="t5">{{$event->formatDate($event->submission_deadline)}}</td>
                            <td headers="t6">{{$event->updateStatus($event->event_status)}}</td>
                            @endforeach
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
