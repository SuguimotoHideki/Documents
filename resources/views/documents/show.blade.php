@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <x-document-nav-menu :document="$document"/>
        <div class="col-md-9">
            <div class="shadow-sm p-3 mb-3 bg-white">
                <h1 class="fs-4 fw-bold text-uppercase mb-1">{{$document->title}}</h1>
                <div class="row">
                    <div class="text-muted">Submissão nº: {{$document->submission->id}}</div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        @if(!Auth::user()->hasRole("reviewer"))
                            <div class="col-md mt-3">
                                <h2 class="fs-default fw-bold mb-1">Autores:</h2>
                                <ul class="mb-0 list-unstyled text-muted">
                                    <li>{{$document->submission->user->user_name}} (Correspondente)</li>
                                    @foreach ($document->coAuthors as $coAuthor)
                                        <li>{{$coAuthor->formatName($coAuthor->name)}}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <div class="col-md mt-3">
                            <h2 class="fs-default fw-bold mb-1">Instituição:</h2>
                            <div class="text-muted">{{$document->institution}}</div>
                        </div>
                        <div class="col-md mt-3">
                            <h2 class="fs-default fw-bold mb-1">Palavras-chave:</h2>
                            <x-list-items : wordList="{{$document->keyword}}"/>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="col-md mt-3">
                            <h2 class="fs-default fw-bold mb-1">Modalidade:</h2>
                            <div class="text-muted">{{ucfirst($document->submissionType->name)}}</div>
                        </div>
                        <div class="col-md mt-3">
                            <h2 class="fs-default fw-bold mb-1">Evento:</h2>
                            <a href="{{ route('showEvent', $document->submission->event)}}" class="text-muted">{{$document->submission->event->name}}</a>
                        </div>
                        @if(!Auth::user()->hasRole('reviewer'))
                        <div class="col-md mt-3">
                            @php
                                $status = $document->submission->getStatusID();
                            @endphp
                            <h2 class="fs-default fw-bold mb-1">Status:</h2>
                            @if($status === 0)
                                <div class="bg-success text-white py-1 px-2 rounded-2 text-md-center w-25">
                                    {{$document->submission->getStatusValue()}}
                                </div>
                            @elseif($status === 1)
                                <div class="bg-warning py-1 px-2 rounded-2 text-md-center w-25">
                                    {{$document->submission->getStatusValue()}}
                                </div>
                            @elseif($status === 2)
                                <div class="bg-danger text-white py-1 px-2 rounded-2 text-md-center w-25">
                                    {{$document->submission->getStatusValue()}}
                                </div>
                            @else
                                <div class="bg-primary text-white py-1 px-2 rounded-2 text-md-center w-25">
                                    {{$document->submission->getStatusValue()}}
                                </div>
                            @endif
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <div class="shadow-sm p-3 bg-white h-100">
                        <div class="col-md">
                            <h2 class="fs-default fw-bold mb-1">
                                <i class="fa-regular fa-clock"></i> Enviado em:</h2>
                            <div>{{$document->formatDate($document->created_at)}}</div>
                        </div>
                        <div class="col-md mt-3">
                            <h2 class="fs-default fw-bold mb-1">
                                <i class="fa-regular fa-clock"></i> Atualizado em:</h2>
                            <div>{{$document->formatDate($document->updated_at)}}</div>
                        </div>
                        <div class="col-md mt-3">
                            @if(!Auth::user()->hasRole("reviewer"))
                                <h2 class="fs-default fw-bold mb-1">
                                    <i class="fa-regular fa-clock"></i> Avaliado em:</h2>
                                <div>{{$document->submission->formatDate($document->submission->reviewed_at)}}</div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <div class="shadow-sm p-3 bg-white h-100">
                        <div class="col-md">
                            @if(!Auth::user()->hasRole("reviewer"))
                                <h2 class="fs-default fw-bold mb-1">
                                    <i class="fa-regular fa-eye"></i> Trabalho com identificação:</h2>
                                <div><a href="/storage/{{$document->attachment_author}}">Clique aqui para abrir o arquivo</a></div>
                            @endif
                        </div>
                        <div class="col-md mt-3">
                            <h2 class="fs-default fw-bold mb-1">
                                <i class="fa-regular fa-eye-slash"></i> Trabalho sem identificação:</h2>
                            <div><a href="/storage/{{$document->attachment_no_author}}">Clique aqui para abrir o arquivo</a></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
