@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="row mb-2">
                <h1 class='fs-2 col'>Submissões em {{$event->event_name}}</h1>
            </div>
            <div class="list-group list-group-flush shadow-sm p-3 mb-5 bg-white">
                <nav class="mb-3 navbar navbar-expand navbar-light bg-white py-0 border-bottom">
                    <div class="navbar-nav me-auto">
                        <a href="{{route('indexSubscribers', $event->id)}}" class="nav-item nav-link">Ver inscrições</a>
                        <a href="{{ route('showEvent', $event->id)}}" class="nav-item nav-link">Ver evento</a>
                    </div>
                </nav>
                <div class="table-responsive">
                    <table class="table table-bordered border-light table-hover bg-white caption-top table-fixed">
                        <caption>N⁰ submissões: {{count($submissions)}}</caption>
                            <colgroup>
                                <col width ="11%">
                                <col width ="11%">
                                <col width ="11%">
                                <col width ="11%">
                                <col width ="11%">
                                <col width ="11%">
                                <col width ="11%">
                                <col width ="11%">
                                <col width ="11%">
                            </colgroup>
                            <thead class="table-light">
                                <tr class="align-middle">
                                    <th id="t1">@sortablelink('id', 'Submissão')</th>
                                    <th id="t2">@sortablelink('title', 'Título')</th>
                                    <th id="t3">@sortablelink('user', 'Autor')</th>
                                    <th id="t4">@sortablelink('type', 'Tipo')</th>
                                    <th id="t5">@sortablelink('status', 'Status')</th>
                                    <th id="t6">@sortablelink('approved_at','Aprovado em')</th>
                                    <th id="t7">@sortablelink('created_at','Publicado em')</th>
                                    <th id="t8">@sortablelink('updated_at', 'Atualizado em')</th>
                                    <th id="t9">Operações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($submissions as $submission)
                                @php
                                    $status = $submission->getStatusID()
                                @endphp
                                <tr class="align-middle" style="height:4rem">
                                    <td headers="t1"><a href="{{ route('showDocument', $submission->document)}}">{{$submission->id}}</a></td>
                                    <td headers="t2" class="text-truncate"><a href="{{ route('showDocument', $submission->document)}}">{{$submission->document->title}}</a></td>
                                    <td headers="t3"><a href="{{ route('showUser', $submission->user)}}">{{$submission->user->user_name}}</a></td>
                                    <td headers="t4">{{$submission->document->type}}</td>
                                    <td headers="t5">
                                        @if($status === 0)
                                        <i class="fas fa-circle text-success"></i>
                                        @elseif($status === 1)
                                        <i class="fas fa-circle text-danger"></i>
                                        @elseif($status === 2)
                                        <i class="fas fa-circle text-warning"></i>
                                        @else
                                        <i class="fas fa-circle text-primary"></i>
                                        @endif
                                        {{ $submission->getStatusValue()}}
                                    </td>
                                    <td headers="t6">{{$submission->formatDate($submission->approved_at)}}</td>
                                    <td headers="t7">{{$submission->formatDate($submission->created_at)}}</td>
                                    <td headers="t8">{{$submission->formatDate($submission->updated_at)}}</td>
                                    <td headers="t9">
                                        <div class="nav-item dropdown">
                                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                                Operações
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                                <a class="dropdown-item" href="{{route('showDocument', $submission->document)}}">
                                                    Ver submissão
                                                </a>
                                                @can(['submissions.edit, submissions.delete'])
                                                    <a class="dropdown-item" href="{{route('editDocument', $submission->document)}}">
                                                        Editar submissão
                                                    </a>
                                                    <button type="button" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#documentDeletePrompt{{$submission->document->id}}">
                                                        Excluir submissão
                                                    </button>
                                                @endif
                                                @can(['submissions.manage'])
                                                    <a class="dropdown-item" href="{{route('indexByDocument', $submission->document)}}">
                                                        Avaliações
                                                    </a>
                                                    <a class="dropdown-item" href="{{route('assignReviewer', $submission->document)}}">
                                                        Avaliadores
                                                    </a>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <div class="modal fade" id="documentDeletePrompt{{$submission->document->id}}" tabindex="-1" aria-labelledby="documentDeletePromptLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Excluir submissão</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <p>Deseja excluir a submissão <strong>{{$submission->document->title}}</strong> do evento <strong>{{$event->event_name}}</strong> ?</p>
                                                <p>Essa operação não pode ser desfeita.</p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                <form action="{{ route('deleteDocument', $submission->document->id)}}" method="POST">
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
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div> 
        </div>
    </div>
</div>
@endsection
