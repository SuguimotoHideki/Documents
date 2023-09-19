@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="row mb-2">
                <h1 class='fs-2 col'>Gerenciar eventos</h1>
                @role('admin')
                    <div class="col">
                        <a href="{{route('createEvent')}}" class="btn btn-success float-end">Criar evento</a>
                    </div>
                @endif
            </div>
            <div class="list-group list-group-flush shadow-sm p-3 mb-5 bg-white">
                <div class="table-responsive">
                    <table class="table table-bordered border-light table-hover bg-white table-fixed">
                        <colgroup>
                            <col width="5%">
                            <col width="20%">
                            <col width="20%">
                            <col width="15%">
                            <col width ="15%">
                            <col width ="15%">
                            <col width ="10%">
                        </colgroup>
                        <thead class="table-light">
                            <tr class="align-middle">
                                <th id="t1">@sortablelink('id', 'ID')</th>
                                <th id="t2">@sortablelink('name', 'Evento')</th>
                                <th id="t3">@sortablelink('email', 'Email do evento')</th>
                                <th id="t4">@sortablelink('organizer', 'Organizador')</th>
                                <th id="t5">@sortablelink('published', 'Publicação')</th>
                                <th id="t6">@sortablelink('status', 'Status')</th>
                                <th id="t7">Operações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($events as $event)
                            <tr class="align-middle" style="height: 4rem">
                                <td headers="t1"><a href="{{route('showEvent', $event)}}">{{$event->id}}</td>
                                <td headers="t2"><a href="{{route('showEvent', $event)}}">{{$event->name}}</a></td>
                                <td headers="t3" class="text-truncate">{{$event->email}}</td>
                                <td headers="t4">{{$event->organizer}}</td>
                                <td headers="t5">
                                    @if($event->published === 1)
                                        <i class="fas fa-circle text-success"></i> Publicado
                                    @else
                                        <i class="fas fa-circle text-danger"></i> Não publicado
                                    @endif
                                </td>
                                <td headers="t6">{{$event->updateStatus($event->status)}}</td>
                                <td headers="t7">
                                    <div class="nav-item dropdown">
                                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                            Operações
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                            <a href="{{ route('indexSubscribers', $event)}}" class="dropdown-item btn rounded-0">
                                                Ver inscrições
                                            </a>

                                            <a href="{{ route('indexEventSubmissions', $event)}}" class="dropdown-item btn rounded-0">
                                                Ver submissões
                                            </a>

                                            <a class="dropdown-item btn rounded-0" href="{{route('showEvent', $event)}}">
                                                Ver evento
                                            </a>

                                            <a class="dropdown-item btn rounded-0" href="{{route('editEvent', $event)}}">
                                                Editar evento
                                            </a>
                                            @if($event->users->isNotEmpty() || $event->submission)
                                                <button type="button" class="dropdown-item btn rounded-0" data-bs-toggle="modal" data-bs-target="#eventDeleteWarning{{$event->id}}">
                                                    Excluir evento
                                                </button>
                                            @else
                                                <button type="button" class="dropdown-item btn rounded-0" data-bs-toggle="modal" data-bs-target="#eventDeletePrompt{{$event->id}}">
                                                    Excluir evento
                                                </button>
                                            @endif
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
                                        <p>Deseja excluir o evento <strong>{{$event->name}}</strong> ?</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                        <form action="{{ route('deleteEvent', $event->id)}}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">
                                                {{ __('Excluir') }}
                                            </button>
                                        </form>
                                    </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal fade" id="eventDeleteWarning{{$event->id}}" tabindex="-1" aria-labelledby="eventDeleteWarningLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Excluir evento</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p>O evento <strong>{{$event->name}}</strong> possui inscritos ou submissões. Remova-as antes de apagar o evento.</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">OK</button>
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
