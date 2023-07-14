@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <h1 class='fs-2'>Eventos inscritos</h1>
            <div class="list-group list-group-flush shadow-sm p-3 mb-5 bg-white">
                <div class="table-responsive">
                    <table class="table bg-white">
                        <colgroup>
                            <col width="20%">
                            <col width="20%">
                            <col width="15%">
                            <col width ="15%">
                            <col width ="15%">
                            <col width ="15%">
                        </colgroup>
                        <thead>
                            <tr class="align-middle">
                                <th id="t1">@sortablelink('event_name', 'Evento')</th>
                                <th id="t2">@sortablelink('event_email', 'Email do evento')</th>
                                <th id="t3">@sortablelink('status', 'Status')</th>
                                <th id="t4">@sortablelink('submission_status', 'Status da submissão')</th>
                                <th id="t5">@sortablelink('subscription_deadline', 'Prazo para submissão')</th>
                                <th id="t6">@sortablelink('created_at', 'Data de inscrição')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($events as $event)
                            <tr class="align-middle">
                                <td headers="t1"><a href="{{route('showEvent', $event)}}">{{$event->event_name}}</a></td>
                                <td headers="t2">{{$event->event_email}}</td>
                                <td headers="t3">{{$event->updateStatus($event->event_status)}}</td>
                                <td headers="t4">{{$event->updateStatus($event->event_status)}}</td>
                                <td headers="t5">{{$event->formatDate($event->submission_start)}} - {{$event->formatDate($event->submission_deadline)}}</td>
                                <td headers="t6">{{$event->formatDate($event->subscription_start)}} - {{$event->formatDate($event->subscription_deadline)}}</td>
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
