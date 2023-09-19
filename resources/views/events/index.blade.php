@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <h1 class='fs-2'>Eventos abertos</h1>
            <div class="list-group list-group-flush shadow-sm p-3 mb-5 bg-white">
                <div class="table-responsive">
                    <table class="table table-bordered border-light table-hover bg-white table-fixed">
                        <colgroup>
                            <col width="20%">
                            <col width="20%">
                            <col width="20%">
                            <col width ="20%">
                            <col width ="20%">
                        </colgroup>
                        <thead class="table-light">
                            <tr class="align-middle">
                                <th id="t1">@sortablelink('name', 'Evento')</th>
                                <th id="t2">@sortablelink('email', 'Email do evento')</th>
                                <th id="t3">@sortablelink('organizer', 'Organizador')</th>
                                <th id="t4">@sortablelink('status', 'Status')</th>
                                <th id="t5">@sortablelink('subscription_deadline', 'Prazo para inscrição')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($events as $event)
                            <tr class="align-middle" style="height:4rem">
                                <td headers="t1"><a href="{{route('showEvent', $event)}}">{{$event->name}}</a></td>
                                <td headers="t5" class="text-truncate">{{$event->email}}</td>
                                <td headers="t3">{{$event->organizer}}</td>
                                <td headers="t4">{{$event->getStatusValue($event->updateStatus($event->status))}}</td>
                                <td headers="t5">{{$event->getSubscriptionDates()}}</td>
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
