@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="row mb-3">
                <h1 class='fs-2 col'>Gerenciar eventos</h1>
                <div class="col">
                    <a href="{{route('createEvent')}}" class="btn btn-success float-end">Criar evento</a>
                </div>
            </div>
            <div class="list-group list-group-flush shadow-sm p-3 mb-5 bg-white">
                <div class="table-responsive">
                    <table class="table bg-white">
                        <colgroup>
                            <col width="5%">
                            <col width="20%">
                            <col width="15%">
                            <col width="15%">
                            <col width ="15%">
                            <col width ="15%">
                            <col width ="15%">
                        </colgroup>
                        <thead>
                            <tr class="align-middle">
                                <th id="t1">@sortablelink('id', 'ID')</th>
                                <th id="t2">@sortablelink('event_name', 'Evento')</th>
                                <th id="t3">@sortablelink('event_email', 'Email do evento')</th>
                                <th id="t4">@sortablelink('organizer', 'Organizador')</th>
                                <th id="t5">@sortablelink('event_published', 'Publicação')</th>
                                <th id="t6">@sortablelink('event_status', 'Status')</th>
                                <th id="t7">Operações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($events as $event)
                            <tr class="align-middle" style="height: 4rem">
                                <td headers="t1"><a href="{{route('showEvent', $event)}}">{{$event->id}}</td>
                                <td headers="t2"><a href="{{route('showEvent', $event)}}">{{$event->event_name}}</a></td>
                                <td headers="t3">{{$event->event_email}}</td>
                                <td headers="t4">{{$event->organizer}}</td>
                                <td headers="t5">
                                    @if($event->event_published === 1)
                                        Publicado
                                    @else
                                        Não publicado
                                    @endif
                                </td>
                                <td headers="t6">{{$event->updateStatus($event->event_status)}}</td>
                                <td headers="t7">
                                    <div class="nav-item dropdown">
                                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                            Operações
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                            <a class="dropdown-item" href="{{route('showEvent', $event)}}">
                                                Visualizar
                                            </a>

                                            <a class="dropdown-item" href="{{route('editEvent', $event)}}">
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
        </div>
    </div>
</div>
@endsection
