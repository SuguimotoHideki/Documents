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
                                    <th id="t1">@sortablelink('event_name', 'Evento')</th>
                                    <th id="t3">@sortablelink('organizer', 'Organizador')</th>
                                    <th id="t2">@sortablelink('event_status', 'Status')</th>
                                    <th id="t4">@sortablelink('subscription_deadline', 'Prazo para inscrição')</th>
                                    <th id="t5">@sortablelink('submission_deadline', 'Prazo para submissão')</th>
                                    <th id="t6">Operações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($events as $event)
                                <tr class="align-middle">
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

                                                <button type="button" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#eventDeletePrompt{{$event->id}}">
                                                    Excluir
                                                </button>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
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
                                                <button type="submit" class="btn btn-primary">
                                                    {{ __('Excluir') }}
                                                </button>
                                            </form>
                                        </div>
                                        </div>
                                    </div>
                                </div>
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
                                    <th id="t1">@sortablelink('event_name', 'Evento')</th>
                                    <th id="t3">@sortablelink('organizer', 'Organizador')</th>
                                    <th id="t2">@sortablelink('event_status', 'Status')</th>
                                    <th id="t4">@sortablelink('subscription_deadline', 'Prazo para inscrição')</th>
                                    <th id="t5">@sortablelink('submission_deadline', 'Prazo para submissão')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($events as $event)
                                <tr class="align-middle">
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
