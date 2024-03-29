@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <x-document-nav-menu :document="$document"/>
        <div class="col-md-9">
            <h1 class='fs-2 mb-2 text-truncate'>{{"Avaliações de $document->title"}}</h1>
            <div class="list-group list-group-flush shadow-sm p-3 bg-white">
                <div class="table-responsive mb-2">
                    <table class="table table-bordered border-light table-hover bg-white table-fixed">
                        @role('admin')
                            <colgroup>
                                <col width ="14%">
                                <col width ="14%">
                                <col width ="14%">
                                <col width ="14%">
                                <col width ="14%">
                                <col width ="14%">
                                <col width ="14%">
                            </colgroup>
                            <thead class="table-light">
                                <tr class="align-middle">
                                    <th id="t1">Título</th>
                                    <th id="t2">Avaliador</th>
                                    <th id="t3">Pontuação</th>
                                    <th id="t4">Recomendação</th>
                                    <th id="t5">Avaliado em</th>
                                    <th id="t6">Atualizado em</th>
                                    <th id="t7">Operações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($reviews as $review)
                                @php
                                    $status = $review->getStatusID()
                                @endphp
                                <tr class="align-middle" style="height:4rem">
                                    <td headers="t1"><a href="{{route('showReview', [$document, $review])}}">{{$review->title}}</a></td>
                                    <td headers="t2">{{$review->user->user_name}}</td>
                                    <td headers="t3">{{$review->score}}</td>
                                    <td headers="t4">
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
                                    <td headers="t5">{{$review->formatDate($review->created_at)}}</td>
                                    <td headers="t6">{{$review->formatDate($review->updated_at)}}</td>
                                    <td headers="t7">
                                        <div class="nav-item dropdown">
                                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                                Operações
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                                <a class="dropdown-item btn rounded-0" href="{{route('showReview', [$review->document, $review])}}">
                                                    Ver avaliação
                                                </a>
                                                <a class="dropdown-item btn rounded-0" href="{{route('editReview', [$review->document, $review])}}">
                                                    Editar avaliação
                                                </a>
                                                <button type="button" class="dropdown-item btn rounded-0" data-bs-toggle="modal" data-bs-target="#reviewDeletePrompt{{$review->id}}">
                                                    Excluir avaliação
                                                </button>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <div class="modal fade" id="reviewDeletePrompt{{$review->id}}" tabindex="-1" aria-labelledby="reviewDeletePromptLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Excluir avaliação</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <p>Deseja excluir a avaliação da submissão <strong>{{$review->document->title}}</strong> ?</p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                <form action="{{ route('deleteReview', [$review->document, $review])}}" method="POST">
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
                        @else
                            <colgroup>
                                <col width ="25%">
                                <col width ="25%">
                                <col width ="25%">
                                <col width ="25%">
                            </colgroup>
                            <thead class="table-light">
                                <tr class="align-middle">
                                    <th id="t1">Título</th>
                                    <th id="t2">Pontuação</th>
                                    <th id="t3">Recomendação</th>
                                    <th id="t4">Avaliado em</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($reviews as $review)
                                @php
                                    $status = $review->getStatusID()
                                @endphp
                                <tr class="align-middle" style="height:4rem">
                                    <td headers="t1"><a href="{{route('showReview', [$document, $review])}}">{{$review->title}}</a></td>
                                    <td headers="t2">{{$review->score}}</td>
                                    <td headers="t3">
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
                                    <td headers="t4">{{$review->formatDate($review->created_at)}}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        @endif
                    </table>
                </div>
                <div>
                    {{$reviews->links('pagination::bootstrap-4')}}
                </div>
            </div> 
        </div>
    </div>
</div>
@endsection
