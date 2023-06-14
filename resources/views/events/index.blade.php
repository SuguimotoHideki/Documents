@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            @if(Route::currentRouteName() === 'home')
                <h1 class='fs-2'>Eventos abertos</h1>
            @elseif(Route::currentRouteName() === 'indexSubscribbedEvents')
                <h1 class='fs-2'>Eventos inscritos</h1>
            @endif
            @can('manage any event')
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
                                    <th id="t3">Organizador</th>
                                    <th id="t2">Status</th>
                                    <th id="t4">Prazo para inscrição</th>
                                    <th id="t5">Prazo para submissão</th>
                                    <th id="t6">Operações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($events as $event)
                                <tr>
                                    <td headers="t1"><a href="/events/{{$event->id}}">{{$event->event_name}}</a></td>
                                    <td headers="t2">{{$event->organizer}}</td>
                                    <td headers="t3">{{$event->updateStatus($event->event_status)}}</td>
                                    <td headers="t4">{{$event->formatDate($event->subscription_start)}} - {{$event->formatDate($event->subscription_deadline)}}</td>
                                    <td headers="t5">{{$event->formatDate($event->submission_start)}} - {{$event->formatDate($event->submission_deadline)}}</td>
                                    <td headers="t6">
                                        <div class="nav-item dropdown">
                                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                                Operações
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                                <a class="dropdown-item" href="/events/{{$event->id}}">
                                                    Visualizar
                                                </a>

                                                <a class="dropdown-item" href="/events/{{$event->id}}/edit">
                                                    Editar
                                                </a>
            
                                                <a class="dropdown-item" href="/users/{{Auth::user()->id}}">
                                                    Excluir
                                                </a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @else
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
                                    <th id="t1">Evento</th>
                                    <th id="t3">Organizador</th>
                                    <th id="t2">Status</th>
                                    <th id="t4">Prazo para inscrição</th>
                                    <th id="t5">Prazo para submissão</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($events as $event)
                                <tr>
                                    <td headers="t1"><a href="/events/{{$event->id}}">{{$event->event_name}}</a></td>
                                    <td headers="t2">{{$event->organizer}}</td>
                                    <td headers="t3">{{$event->updateStatus($event->event_status)}}</td>
                                    <td headers="t4">{{$event->formatDate($event->subscription_start)}} - {{$event->formatDate($event->subscription_deadline)}}</td>
                                    <td headers="t5">{{$event->formatDate($event->submission_start)}} - {{$event->formatDate($event->submission_deadline)}}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div> 
            @endcan
        </div>
    </div>
</div>
@endsection
