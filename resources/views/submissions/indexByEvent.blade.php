@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="row mb-3">
                <h1 class='fs-2 col'>Submissões em {{$event->event_name}}</h1>
            </div>
            @if($submissions->count() === 0)
                <div class="text-center">
                    <p>Ainda não há submissões para este evento.</p>
                </div>
            @else
            <div class="list-group list-group-flush shadow-sm p-3 mb-5">
                <div class="table-responsive">
                    <table class="table table-bordered border-light table-hover caption-top">
                        <caption>Número de submissões: {{count($submissions)}}</caption>
                            <colgroup>
                                <col width="6%">
                                <col width="20%">
                                <col width="20%">
                                <col width ="9%">
                                <col width ="9%">
                                <col width ="12%">
                                <col width ="12%">
                                <col width ="12%">
                            </colgroup>
                            <thead class="table-light">
                                <tr class="align-middle">
                                    <th id="t1">@sortablelink('id', 'ID')</th>
                                    <th id="t2">@sortablelink('title', 'Título')</th>
                                    <th id="t3">@sortablelink('user', 'Author correspondente')</th>
                                    <th id="t4">@sortablelink('document_type', 'Tipo')</th>
                                    <th id="t5">@sortablelink('status', 'Status')</th>
                                    <th id="t6">@sortablelink('approved_at','Aprovado em')</th>
                                    <th id="t7">@sortablelink('created_at','Publicado em')</th>
                                    <th id="t8">@sortablelink('updated_at', 'Atualizado em')</th>
                                    <th id="t9">Operações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($submissions as $submission)
                                <tr class="align-middle" style="height:4rem">
                                    <td headers="t1"><a href="{{ route('showDocument', $submission->document)}}">{{$submission->id}}</a></td>
                                    <td headers="t2"><a href="{{ route('showDocument', $submission->document)}}">{{$submission->document->title}}</a></td>
                                    <td headers="t3"><a href="{{ route('showUser', $submission->user)}}">{{$submission->user->user_name}}</a></td>
                                    <td headers="t4">{{$submission->document->document_type}}</td>
                                    <td headers="t5">{{$submission->getStatusValue()}}</td>
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
                                                    Visualizar
                                                </a>
    
                                                <a class="dropdown-item" href="{{route('editDocument', $submission->document)}}">
                                                    Editar
                                                </a>
    
                                                <button type="button" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#documentDeletePrompt{{$submission->document->id}}">
                                                    Excluir
                                                </button>
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
            @endif
        </div>
    </div>
</div>
@endsection
