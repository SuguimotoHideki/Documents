@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="list-group - list-group-flush shadow-sm p-3 mb-5 bg-white">
                <h1 class="fs-3 text-uppercase">{{$document->title}}</h1>
                <div class="mt-3">
                    <div class="fw-bold">Autor:</div>
                    <div>{{$document->author}}</div>
                </div>
                <div class="mt-3">
                    <div class="fw-bold">Instituição:</div>
                    <div>{{$document->document_institution}}</div>
                </div>
                <div class="mt-3">
                    <div class="fw-bold">Data de publicação:</div>
                    <div>{{$document->getCreatedAttribute()}}</div>
                </div>
                <div class="mt-3">
                    <div class="fw-bold">Resumo:</div>
                    <div>{{$document->abstract}}</div>
                </div>
                <div class="mt-3">
                    <div class="fw-bold">Palavras chave:</div>
                    <x-list-items : wordList="{{$document->keyword}}"/>
                </div>
                <div class="mt-3">
                    <div class="fw-bold">Tipo de documento:</div>
                    <div>{{$document->document_type}}</div>
                </div>
                <div class="mt-3">
                    <div class="fw-bold">Arquivo:</div>
                    <div>
                        <a href="/storage/{{$document->document}}">Visualizar arquivo</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
