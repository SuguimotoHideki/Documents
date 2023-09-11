@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <h1 class="fs-3 fw-bold text-uppercase text-center mb-3">Avaliação</h1>
        @role(['admin', 'event moderator', 'reviewer'])
            <div class="col-md-9">
                <div class="shadow-sm p-3 mb-5 bg-white">
                    <nav class="mb-3 navbar navbar-expand navbar-light bg-white py-0 border-bottom">
                        <div class="navbar-nav me-auto">
                            @can('reviews.edit')
                                <a href="{{route('editReview', [$document, $review])}}" class="nav-item nav-link">Editar avaliação</a>
                            @endif
                            @can('reviews.manage')
                                <a href="{{ route('indexByDocument', $document->id)}}" class="nav-item nav-link">Ver avaliações</a>
                            @endif
                            <a href="{{ route('showDocument', $document->id)}}" class="nav-item nav-link">Ver submissão</a>
                        </div>
                    </nav>
                    <div class="row">
                        <div class="text-muted">Avaliação nº: {{$review->id}}</div>
                    </div>
                    <div class="row">
                        <div class="col-md mt-3">
                            <h2 class="fs-5 fw-bold">Título:</h2>
                            <div>{{$review->title}}</div>
                        </div>
                        <div class="col-md mt-3">
                            <h2 class="fs-5 fw-bold">Avaliador:</h2>
                            <div>{{$review->user->user_name}}</div>
                        </div>
                    </div>
                    <div class="mt-3 text-break">
                        <h2 class="fs-5 fw-bold text-start">Comentário:</h2>
                        <div>{{$review->comment}}</div>
                    </div>
                    <div class="mt-3 text-break">
                        <h2 class="fs-5 fw-bold text-start">Comentário privado:</h2>
                        <div>{{$review->moderator_comment}}</div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="shadow-sm p-3 mb-3 bg-white">
                    <h2 class="fs-5 fw-bold mt-3">Pontuação:</h2>
                        <div class="mt-2">{{$review->score}}</div>
                    <h2 class="fs-5 fw-bold mt-3">Recomendação:</h2>
                        <div class="mt-2">
                            @php
                            $status = $review->getStatusID()
                            @endphp
                            @if($status === 0)
                            <i class="fas fa-circle text-success"></i>
                            @elseif($status === 1)
                            <i class="fas fa-circle text-warning"></i>
                            @elseif($status === 2)
                            <i class="fas fa-circle text-danger"></i>
                            @endif
                            {{$review->getStatusValue()}}
                        </div>
                </div>
                @if($review->attachment !== null)
                <div class="shadow-sm p-3 mb-3 bg-white">
                    <h2 class="fs-5 fw-bold mt-3">
                        <i class="fa-regular fa-file"></i> Visualizar anexo:</h2>
                    <div class="mt-2"><a href="/storage/{{$review->attachment}}">Clique aqui para abrir o arquivo</a></div>
                </div>
                @endif
                <div class="shadow-sm p-3 mb-3 bg-white">
                    <h2 class="fs-5 fw-bold mt-3">
                        <i class="fa-regular fa-clock"></i> Enviado em:</h2>
                    <div class="mt-2">{{$review->formatDate($review->created_at)}}</div>
                    <h2 class="fs-5 fw-bold mt-3">
                        <i class="fa-regular fa-clock"></i> Atualizado em:</h2>
                    <div class="mt-2">{{$review->formatDate($review->updated_at)}}</div>
                </div>
            </div>
        @else
            <div class="col-md-9">
                <div class="shadow-sm p-3 mb-5 bg-white">
                    <nav class="mb-3 navbar navbar-expand navbar-light bg-white py-0 border-bottom">
                        <div class="navbar-nav me-auto">
                            <a href="{{ route('indexByDocument', $document)}}" class="nav-item nav-link">Ver avaliações</a>
                            <a href="{{ route('showDocument', $document)}}" class="nav-item nav-link">Ver submissão</a>
                        </div>
                    </nav>
                    <div class="mt-3 text-break">
                        <h2 class="fs-5 fw-bold text-start">Título:</h2>
                        <div>{{$review->title}}</div>
                    </div>
                    <div class="mt-3 text-break">
                        <h2 class="fs-5 fw-bold text-start">Comentário:</h2>
                        <div>{{$review->comment}}</div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="shadow-sm p-3 mb-3 bg-white">
                    <h2 class="fs-5 fw-bold mt-3">Pontuação:</h2>
                        <div class="mt-2">{{$review->score}}</div>
                    <h2 class="fs-5 fw-bold mt-3">Recomendação:</h2>
                        <div class="mt-2">
                            @php
                            $status = $review->getStatusID()
                            @endphp
                            @if($status === 0)
                            <i class="fas fa-circle text-success"></i>
                            @elseif($status === 1)
                            <i class="fas fa-circle text-warning"></i>
                            @elseif($status === 2)
                            <i class="fas fa-circle text-danger"></i>
                            @endif
                            {{$review->getStatusValue()}}
                        </div>
                </div>
                @if($review->attachment !== null)
                <div class="shadow-sm p-3 mb-3 bg-white">
                    <h2 class="fs-5 fw-bold mt-3">
                        <i class="fa-regular fa-file"></i> Visualizar anexo:</h2>
                    <div class="mt-2"><a href="/storage/{{$review->attachment}}">Clique aqui para abrir o arquivo</a></div>
                </div>
                @endif
            </div>
        @endif
    </div>
</div>

@endsection
