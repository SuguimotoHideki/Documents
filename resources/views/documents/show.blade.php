@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <h1 class="fs-3 fw-bold text-uppercase text-center mb-3">{{$document->title}}</h1>
        <div class="col-md-9">
            <div class="shadow-sm p-3 mb-5 bg-white">
                <nav class="mb-3 navbar navbar-expand navbar-light bg-white py-0 border-bottom">
                    <div class="navbar-nav me-auto">
                        <a href="{{ route('editDocument', $document->id)}}" class="nav-item nav-link">Editar submissão</a>
                    </div>
                </nav>
                <div class="mt-3 text-break">
                    <h2 class="fs-5 fw-bold text-start">Resumo:</h2>
                    <div>{{$document->abstract}}</div>
                </div>
                <div class="row">
                    <div class="col-md">
                        <div class="mt-3">
                            <h2 class="fs-5 fw-bold">Instituição:</h2>
                            <div>{{$document->document_institution}}</div>
                        </div>
                        <div class="mt-3">
                            <h2 class="fs-5 fw-bold">Autores:</h2>
                            <ul class="mb-0">
                                <li>{{$document->users()->first()->user_name}} (Correspondente)</li>
                                @foreach ($document->coAuthors as $coAuthor)
                                    <li>{{$coAuthor->name}}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <div class="col-md">
                        <div class="mt-3">
                            <h2 class="fs-5 fw-bold">Tipo de documento:</h2>
                            <div>{{$document->document_type}}</div>
                        </div>
                        <div class="mt-3">
                            <h2 class="fs-5 fw-bold">Palavras-chave:</h2>
                            <x-list-items : wordList="{{$document->keyword}}"/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="shadow-sm p-3 mb-3 bg-white">
                <div>
                    <h2 class="fs-5 fw-bold mt-3">
                        <i class="fa-regular fa-clock"></i> Enviado em:</h2>
                    <div class="mt-2">{{$document->formatDate($document->created_at)}}</div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
