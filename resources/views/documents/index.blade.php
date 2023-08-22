@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="row mb-2">
                <h1 class='fs-2 col'>Gerenciar submissões</h1>
                @if($documents->count() === 0)
                    <div class="text-center">
                        <p>Ainda não há submissões.</p>
                    </div>
                @else
            </div>
            <div class="list-group list-group-flush shadow-sm p-3 mb-5 bg-white">
                <div class="table-responsive">
                    <table class="table table-bordered border-light table-hover bg-white">
                            <colgroup>
                                <col width="5%">
                                <col width="10%">
                                <col width="13%">
                                <col width ="12%">
                                <col width ="10%">
                                <col width ="10%">
                                <col width ="11%">
                                <col width ="10%">
                                <col width ="11%">
                                <col width ="8%">
                            </colgroup>
                            <thead class="table-light">
                                <tr class="align-middle">
                                    <th id="t1">@sortablelink('id', 'ID')</th>
                                    <th id="t2">@sortablelink('event', 'Evento')</th>
                                    <th id="t3">@sortablelink('title', 'Título')</th>
                                    <th id="t4">@sortablelink('user', 'Correspondente')</th>
                                    <th id="t5">@sortablelink('document_type', 'Tipo')</th>
                                    <th id="t6">@sortablelink('status', 'Status')</th>
                                    <th id="t7">@sortablelink('approved_at', 'Aprovado em')</th>
                                    <th id="t8">@sortablelink('created_at', 'Criado em')</th>
                                    <th id="t9">@sortablelink('updated_at', 'Atualizado em')</th>
                                    <th id="t10">Operações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($documents as $document)
                                <tr class="align-middle" style="height:4rem">
                                    <td headers="t1"><a href="{{route('showDocument', $document)}}">{{$document->id}}</a></td>
                                    <td headers="t2"><a href="{{route('showEvent', $document->submission->event)}}">{{$document->submission->event->event_name}}</a></td>
                                    <td headers="t3"><a href="{{route('showDocument', $document)}}">{{$document->title}}</a></td>
                                    <td headers="t4"><a href="{{ route('showUser', $document->submission->user)}}">{{$document->submission->user->user_name}}</a></td>
                                    <td headers="t5">{{$document->document_type}}</td>
                                    <td headers="t6">{{$document->submission->getStatusValue()}}</td>
                                    <td headers="t7">{{$document->submission->formatDate($document->submission->approved_at)}}</td>
                                    <td headers="t8">{{$document->formatDate($document->created_at)}}</td>
                                    <td headers="t9">{{$document->formatDate($document->updated_at)}}</td>
                                    <td headers="t10">
                                        <div class="nav-item dropdown">
                                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                                Operações
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                                <a class="dropdown-item" href="{{route('showDocument', $document)}}">
                                                    Visualizar
                                                </a>
    
                                                <a class="dropdown-item" href="{{route('editDocument', $document)}}">
                                                    Editar
                                                </a>
    
                                                <button type="button" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#documentDeletePrompt{{$document->id}}">
                                                    Excluir
                                                </button>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <div class="modal fade" id="documentDeletePrompt{{$document->id}}" tabindex="-1" aria-labelledby="documentDeletePromptLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Excluir submissão</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <p>Deseja excluir a submissão <strong>{{$document->title}}</strong> do evento <strong>{{$document->submission->event->event_name}}</strong> ?</p>

                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                <form action="{{ route('deleteDocument', $document->id)}}" method="POST">
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
            @endif
        </div>
    </div>
</div>
@endsection
