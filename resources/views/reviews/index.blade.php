@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            @can('reviews.manage')
            <h1 class='fs-2'>Gerenciar avaliações</h1>
            <div class="list-group list-group-flush shadow-sm p-3 bg-white">
                <form action="{{route('manageReviews')}}" method="GET">
                    <div class="row">
                        <div class="col-md-10 mb-3">
                            <input name="search" class="form-control" type="text" placeholder="Buscar pelo título ou avaliador" aria-label="Search">
                        </div>
                        <div class="col-md-2 mb-3">
                            <button class="btn btn-primary w-100"><i class="fa-solid fa-magnifying-glass"></i> Buscar</button>
                        </div>
                    </div>
                </form>
                <div class="table-responsive mb-2">
                    <table class="table table-bordered border-light table-hover bg-white table-fixed">
                        <colgroup>
                            <col width ="12%">
                            <col width ="12%">
                            <col width ="20%">
                            <col width ="8%">
                            <col width ="12%">
                            <col width ="12%">
                            <col width ="12%">
                            <col width ="12%">
                        </colgroup>
                        <thead class="table-light">
                            <tr class="align-middle">
                                <th id="t1">@sortablelink('title', 'Título')</th>
                                <th id="t2">@sortablelink('user.user_name', 'Avaliador')</th>
                                <th id="t3">Submissão</th>
                                <th id="t4">@sortablelink('score', 'Pontuação')</th>
                                <th id="t5">Recomendação</th>
                                <th id="t6">@sortablelink('created_at', 'Avaliado em')</th>
                                <th id="t7">@sortablelink('updated_at', 'Atualizado em')</th>
                                <th id="t8">Operações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($reviews as $review)
                            @php
                                $status = $review->getStatusID()
                            @endphp
                            <tr class="align-middle" style="height:4rem">
                                <td headers="t1"><a href="{{route('showReview', [$review->document, $review])}}">{{$review->title}}</a></td>
                                <td headers="t2"><a href="{{route('showUser', $review->user->id)}}">{{$review->user->user_name}}</a></td>
                                <td headers="t3" class="text-truncate"><a href="{{ route('showDocument', $review->document)}}">{{$review->document->title}}</a></td>
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
                                <td headers="t7">{{$review->formatDate($review->updated_at)}}</td>
                                <td headers="t8">
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
                                            <a class="dropdown-item btn rounded-0" href="{{route('showDocument', $review->document)}}">
                                                Ver submissão
                                            </a>
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
                    </table>
                </div>
                <div>
                    {{$reviews->links('pagination::bootstrap-4')}}
                </div>
            </div> 
            @else
            <h1 class='fs-2'>Avaliações</h1>
            <div class="list-group list-group-flush shadow-sm p-3 bg-white">
                <div class="table-responsive mb-2">
                    <table class="table table-bordered border-light table-hover bg-white table-fixed">
                        <colgroup>
                            <col width ="15%">
                            <col width ="15%">
                            <col width ="15%">
                            <col width ="15%">
                            <col width ="15%">
                            <col width ="15%">
                            <col width ="15%">
                        </colgroup>
                        <thead class="table-light">
                            <tr class="align-middle">
                                <th id="t1">Título</th>
                                <th id="t2">Submissão</th>
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
                                <td headers="t1"><a href="{{route('showReview', [$review->document, $review])}}">{{$review->title}}</a></td>
                                <td headers="t2" class="text-truncate"><a href="{{ route('showDocument', $review->document)}}">{{$review->document->title}}</a></td>
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
                                            <a class="dropdown-item btn rounded-0" href="{{route('showDocument', $review->document)}}">
                                                Ver submissão
                                            </a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div>
                    {{$reviews->links('pagination::bootstrap-4')}}
                </div>
            </div> 
            @endif
        </div>
    </div>
</div>
@endsection
