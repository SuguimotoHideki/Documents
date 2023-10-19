@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <x-event-nav-menu :event="$event"/>
        <div class="col-md-9">
            <div class="row mb-2">
                <h1 class='fs-2 col'>Submissões em {{$event->name}}</h1>
            </div>
            <div class="list-group list-group-flush shadow-sm p-3 bg-white">
                <div class="table-responsive mb-2">
                    <table class="table table-bordered border-light table-hover bg-white table-fixed caption-top x-scroll">
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
                                <th id="t4">@sortablelink('type', 'Modalidade')</th>
                                <th id="t5">@sortablelink('status', 'Status')</th>
                                <th id="t6">@sortablelink('reviewed_at','Avaliado em')</th>
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
                                <td headers="t4">{{ucfirst($submission->document->submissionType->name)}}</td>
                                <td headers="t5">
                                    @if($status === 0)
                                        <div class="bg-success text-white mx-3 py-1 rounded-2 text-center">
                                            {{$submission->getStatusValue()}}
                                        </div>
                                    @elseif($status === 1)
                                        <div class="bg-warning mx-3 py-1 rounded-2 text-center">
                                            {{$submission->getStatusValue()}}
                                        </div>
                                    @elseif($status === 2)
                                        <div class="bg-danger text-white mx-3 py-1 rounded-2 text-center">
                                            {{$submission->getStatusValue()}}
                                        </div>
                                    @else
                                        <div class="bg-primary text-white mx-3 py-1 rounded-2 text-center">
                                            {{$submission->getStatusValue()}}
                                        </div>
                                    @endif
                                </td>
                                <td headers="t6">{{$submission->formatDate($submission->reviewed_at)}}</td>
                                <td headers="t7">{{$submission->formatDate($submission->created_at)}}</td>
                                <td headers="t8">{{$submission->formatDate($submission->updated_at)}}</td>
                                <td headers="t9">
                                    <div class="nav-item dropdown">
                                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                            Operações
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                            @can(['submissions.edit, submissions.delete'])
                                                <a class="dropdown-item btn rounded-0" href="{{route('editDocument', $submission->document)}}">
                                                    Editar
                                                </a>
                                                <button type="button" class="dropdown-item btn rounded-0" data-bs-toggle="modal" data-bs-target="#documentDeletePrompt{{$submission->document->id}}">
                                                    Excluir
                                                </button>
                                            @endif
                                            @can(['submissions.manage'])
                                                <a class="dropdown-item btn rounded-0" href="{{route('indexByDocument', $submission->document)}}">
                                                    Avaliações
                                                </a>
                                                <a class="dropdown-item btn rounded-0" href="{{route('assignReviewer', $submission->document)}}">
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
                                            <p>Deseja excluir a submissão <strong>{{$submission->document->title}}</strong> do evento <strong>{{$event->name}}</strong> ?</p>
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
                <div>
                    {{$submissions->links('pagination::bootstrap-4')}}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
