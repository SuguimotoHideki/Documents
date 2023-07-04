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
                            <col width="20%">
                            <col width="20%">
                            <col width ="20%">
                            <col width ="20%">
                        </colgroup>
                        <thead>
                            <tr>
                                <th id="t1">@sortablelink('event_name', 'Evento')</th>
                                <th id="t2">@sortablelink('event_email', 'Email do evento')</th>
                                <th id="t3">@sortablelink('organizer', 'Organizador')</th>
                                <th id="t4">@sortablelink('event_status', 'Status')</th>
                                <th id="t5">@sortablelink('subscription_deadline', 'Prazo para inscrição')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($events as $event)
                            <tr class="align-middle" style="height:4rem">
                                <td headers="t1"><a href="/events/{{$event->id}}">{{$event->event_name}}</a></td>
                                <td headers="t5">{{$event->event_email}}</td>
                                <td headers="t3">{{$event->organizer}}</td>
                                <td headers="t4">{{$event->updateStatus($event->event_status)}}</td>
                                <td headers="t5">{{$event->formatDate($event->subscription_start)}} - {{$event->formatDate($event->subscription_deadline)}}</td>
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
