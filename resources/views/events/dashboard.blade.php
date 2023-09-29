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
            <div class="list-group list-group-flush shadow-sm p-3 bg-white">
                <div class="table-responsive mb-2">
                    <table class="table table-bordered border-light table-hover bg-white table-fixed">
                        <colgroup>
                            <col width="6%">
                            <col width="15%">
                            <col width="15%">
                            <col width="12%">
                            <col width ="12%">
                            <col width ="12%">
                            <col width ="12%">
                            <col width ="12%">
                        </colgroup>
                        <thead class="table-light">
                            <tr class="align-middle">
                                <th id="t1">@sortablelink('id', 'ID')</th>
                                <th id="t2">@sortablelink('name', 'Título')</th>
                                <th id="t3">@sortablelink('email', 'Email')</th>
                                <th id="t4">@sortablelink('organizer', 'Organizador')</th>
                                <th id="t5">@sortablelink('published', 'Publicação')</th>
                                <th id="t6">@sortablelink('status', 'Inscrições')</th>
                                <th id="t7">@sortablelink('status', 'Submissões')</th>
                                <th id="t8">Operações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($events as $event)
                            @php
                                $event->updateStatus()
                            @endphp
                            <tr class="align-middle" style="height: 4rem">
                                <td headers="t1"><a href="{{route('showEvent', $event)}}">{{$event->id}}</td>
                                <td headers="t2"><a href="{{route('showEvent', $event)}}">{{$event->name}}</a></td>
                                <td headers="t3" class="text-truncate">{{$event->email}}</td>
                                <td headers="t4">{{$event->organizer}}</td>
                                <td headers="t5">
                                    @if($event->published === 1)
                                        <div class="bg-success text-white mx-3 py-1 rounded-2 text-center">
                                            Publicado
                                        </div>
                                    @else
                                        <div class="bg-danger text-white mx-3 py-1 rounded-2 text-center">
                                            Não publicado
                                        </div>
                                    @endif
                                </td>
                                <td headers="t6">
                                    @if($event->getStatusID() === 0)
                                        <div class="bg-secondary text-white mx-3 py-1 rounded-2 text-center">
                                            Em breve
                                        </div>
                                    @elseif($event->getStatusID() === 1)
                                        <div class="bg-success text-white mx-3 py-1 rounded-2 text-center">
                                            Abertas
                                        </div>
                                    @else
                                        <div class="bg-danger text-white mx-3 py-1 rounded-2 text-center">
                                            Encerradas
                                        </div>
                                    @endif
                                </td>

                                <td headers="t7">
                                    @if($event->getStatusID() < 3)
                                        <div class="bg-secondary text-white mx-3 py-1 rounded-2 text-center">
                                            Em breve
                                        </div>
                                    @elseif($event->getStatusID() === 3)
                                        <div class="bg-success text-white mx-3 py-1 rounded-2 text-center">
                                            Abertas
                                        </div>
                                    @else
                                        <div class="bg-danger text-white mx-3 py-1 rounded-2 text-center">
                                            Encerradas
                                        </div>
                                    @endif
                                </td>
                                <td headers="t8">
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
                                            @role('admin')
                                                @if($event->users->isNotEmpty() || $event->submission)
                                                    <button type="button" class="dropdown-item btn rounded-0" data-bs-toggle="modal" data-bs-target="#eventDeleteWarning{{$event->id}}">
                                                        Excluir evento
                                                    </button>
                                                @else
                                                    <button type="button" class="dropdown-item btn rounded-0" data-bs-toggle="modal" data-bs-target="#eventDeletePrompt{{$event->id}}">
                                                        Excluir evento
                                                    </button>
                                                @endif
                                            @endrole
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
                <div>
                    {{$events->links('pagination::bootstrap-4')}}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
