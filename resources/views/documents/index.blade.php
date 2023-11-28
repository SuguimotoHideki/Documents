@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        @if(Auth::user()->hasRole(['reviewer']) || (Auth::user()->hasRole(['admin']) && isset($user)))
        <div class="col-md-12">
            <div class="row mb-2">
                <h1 class='fs-2 col mb-2'>{{$title}}</h1>
                @if($documents->count() === 0 && !request()->has('search'))
                    <div class="text-center">
                        <p>Ainda não há submissões.</p>
                    </div>
                @else
            </div>
            <div class="list-group list-group-flush shadow-sm p-3 bg-white">
                @isset($user)
                    <form action="{{route('indexReviewed', $user)}}" method="GET">
                @else
                    <form action="{{route('manageDocuments')}}" method="GET">
                @endif
                    <div class="row">
                        <div class="col-md-10 mb-3">
                            <input name="search" class="form-control" type="text" placeholder="Buscar pelo ID ou título" aria-label="Search">
                        </div>
                        <div class="col-md-2 mb-3">
                            <button class="btn btn-primary w-100"><i class="fa-solid fa-magnifying-glass"></i> Buscar</button>
                        </div>
                    </div>
                </form>
                <div class="table-responsive mb-2">
                    <table class="table table-bordered border-light table-hover bg-white table-fixed">
                        <colgroup>
                            <col width="14%">
                            <col width="14%">
                            <col width="14%">
                            <col width ="14%">
                            <col width ="14%">
                            <col width ="14%">
                            <col width ="14%">
                        </colgroup>
                        <thead class="table-light">
                            <tr class="align-middle">
                                <th id="t1">@sortablelink('title', 'Submissão')</th>
                                <th id="t2">@sortablelink('type', 'Modalidade')</th>
                                <th id="t3">Evento</th>
                                <th id="t4">Pontuação</th>
                                <th id="t5">Recomendação</th>
                                <th id="t6">Avaliado em</th>
                                <th id="t7">Operações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($documents as $document)
                            @php
                                if(isset($user))
                                {
                                    $review = $document->review()->where('user_id', $user->id)->first();
                                }
                                else {
                                    $review = $document->review()->where('user_id', Auth::user()->id)->first();
                                }
                                if($review !== null)
                                {
                                    $status = $review->getStatusID();
                                }
                            @endphp
                            <tr class="align-middle" style="height:4rem">
                                <td headers="t1" class="text-truncate"><a href="{{route('showDocument', $document)}}">{{$document->title}}</a></td>
                                <td headers="t2">{{ucfirst($document->submissionType->name)}}</td>
                                <td headers="t3"><a href="{{route('showEvent', $document->submission->event)}}">{{$document->submission->event->name}}</a></td>
                                @if($review !== null)
                                    <td headers="t4">{{$review->score}}</td>
                                    <td headers="t5">
                                        @if($status === 0)
                                            <div class="bg-success text-white mx-3 py-1 px-2 rounded-2 text-center">
                                                {{$review->getStatusValue()}}
                                            </div>
                                        @elseif($status === 1)
                                            <div class="bg-warning mx-3 py-1 px-2 rounded-2 text-center">
                                                {{$review->getStatusValue()}}
                                            </div>
                                        @elseif($status === 2)
                                            <div class="bg-danger text-white mx-3 py-1 px-2 rounded-2 text-center">
                                                {{$review->getStatusValue()}}
                                            </div>
                                        @endif
                                    </td>
                                    <td headers="t6">{{$review->formatDate($review->created_at)}}</td>
                                @else
                                    <td headers="t4">Aguardando avaliação</td>
                                    <td headers="t5">
                                        <a href="{{route('createReview', $document)}}" class="btn btn-primary text-white mx-3 py-1 px-4 rounded-2 text-center">
                                            Avaliar submissão
                                        </a>
                                    </td>
                                    <td headers="t6">Aguardando avaliação</td>
                                @endif
                                <td headers="t7">
                                    <div class="nav-item dropdown">
                                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                            Operações
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                            @if($review !== null)
                                                <a class="dropdown-item btn rounded-0" href="{{route('showReview', [$document, $review])}}">
                                                    Ver avaliação
                                                </a>
                                                <a class="dropdown-item btn rounded-0" href="{{route('editReview', [$document, $review])}}">
                                                    Editar avaliação
                                                </a>
                                            @else
                                                <a class="dropdown-item btn rounded-0" href="{{route('createReview', $document)}}">
                                                    Avaliar submissão
                                                </a>
                                            @endif
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
                                            <p>Deseja excluir a submissão <strong>{{$document->title}}</strong> do evento <strong>{{$document->submission->event->name}}</strong> ?</p>

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
                <div>
                    {{$documents->links('pagination::bootstrap-4')}}
                </div>
            </div> 
            @endif
        </div>
        @else
        <div class="col-md-12">
            <div class="row mb-2">
                <h1 class='fs-2 col mb-2'>{{$title}}</h1>
                @if($documents->count() === 0 && !request()->has('search'))
                    <div class="text-center">
                        <p>Ainda não há submissões.</p>
                    </div>
                @else
            </div>
            <div class="list-group list-group-flush shadow-sm p-3 bg-white">
                <form action="{{route('manageDocuments')}}" method="GET">
                    <div class="row">
                        <div class="col-md-10 mb-3">
                            <input name="search" class="form-control" type="text" placeholder="Buscar pelo ID, título ou autor" aria-label="Search">
                        </div>
                        <div class="col-md-2 mb-3">
                            <button class="btn btn-primary w-100"><i class="fa-solid fa-magnifying-glass"></i> Buscar</button>
                        </div>
                    </div>
                </form>
                <div class="table-responsive mb-2">
                    <table class="table table-bordered border-light table-hover bg-white table-fixed">
                        <colgroup>
                            <col width="5%">
                            <col width="12%">
                            <col width="12%">
                            <col width ="12%">
                            <col width ="12%">
                            <col width ="12%">
                            <col width ="12%">
                            <col width ="12%">
                            <col width ="10%">
                        </colgroup>
                        <thead class="table-light">
                            <tr class="align-middle">
                                <th id="t1">@sortablelink('id', 'ID')</th>
                                <th id="t2">@sortablelink('title', 'Título')</th>
                                <th id="t3">Autor</th>
                                <th id="t4">Modalidade</th>
                                <th id="t5">@sortablelink('submission.status', 'Status')</th>
                                <th id="t6">Evento</th>
                                <th id="t7">@sortablelink('reviewed_at', 'Avaliado em')</th>
                                <th id="t8">@sortablelink('created_at', 'Criado em')</th>
                                <th id="t9">Operações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($documents as $document)
                            @php
                                $status = $document->submission->getStatusID()
                            @endphp
                            <tr class="align-middle" style="height:4rem">
                                <td headers="t1"><a href="{{route('showDocument', $document)}}">{{$document->id}}</a></td>
                                <td headers="t2" class="text-truncate"><a href="{{route('showDocument', $document)}}">{{$document->title}}</a></td>
                                <td headers="t3"><a href="{{ route('showUser', $document->submission->user)}}">{{$document->submission->user->user_name}}</a></td>
                                <td headers="t4">{{ucfirst($document->submissionType->name)}}</td>
                                <td headers="t5">
                                    @if($status === 0)
                                        <div class="bg-success text-white mx-3 py-1 rounded-2 text-center">
                                            {{$document->submission->getStatusValue()}}
                                        </div>
                                    @elseif($status === 1)
                                        <div class="bg-warning mx-3 py-1 rounded-2 text-center">
                                            {{$document->submission->getStatusValue()}}
                                        </div>
                                    @elseif($status === 2)
                                        <div class="bg-danger text-white mx-3 py-1 rounded-2 text-center">
                                            {{$document->submission->getStatusValue()}}
                                        </div>
                                    @else
                                        <div class="bg-primary text-white mx-3 py-1 rounded-2 text-center">
                                            {{$document->submission->getStatusValue()}}
                                        </div>
                                    @endif
                                </td>
                                <td headers="t6"><a href="{{route('showEvent', $document->submission->event)}}">{{$document->submission->event->name}}</a></td>
                                <td headers="t7">{{$document->submission->formatDate($document->submission->reviewed_at)}}</td>
                                <td headers="t8">{{$document->formatDate($document->created_at)}}</td>
                                <td headers="t9">
                                    <div class="nav-item dropdown">
                                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                            Operações
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                            @can(['submissions.edit, submissions.delete'])
                                                <a class="dropdown-item btn rounded-0" href="{{route('editDocument', $document)}}">
                                                    Editar
                                                </a>
                                                <button type="button" class="dropdown-item btn rounded-0" data-bs-toggle="modal" data-bs-target="#documentDeletePrompt{{$document->id}}">
                                                    Excluir
                                                </button>
                                            @endif
                                            @can(['submissions.manage'])
                                                <a class="dropdown-item btn rounded-0" href="{{route('indexByDocument', $document)}}">
                                                    Avaliações
                                                </a>
                                                <a class="dropdown-item btn rounded-0" href="{{route('assignReviewer', $document)}}">
                                                    Avaliadores
                                                </a>
                                            @endif
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
                                            <p>Deseja excluir a submissão <strong>{{$document->title}}</strong> do evento <strong>{{$document->submission->event->name}}</strong> ?</p>

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
                <div>
                    {{$documents->links('pagination::bootstrap-4')}}
                </div>
            </div> 
            @endif
        </div>
        @endif
    </div>
</div>
@endsection
