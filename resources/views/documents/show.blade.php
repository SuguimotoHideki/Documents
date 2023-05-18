@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="list-group - list-group-flush shadow-sm p-3 mb-5 bg-white">
                <div class="row">
                    <span class="text-xl uppercase fw-bold">{{$document->title}}</span>
                </div>
                <div class="mt-4">
                    <div>
                        <span class="fw-bold">Autor:</span>
                    </div>
                    <div>
                        <span>{{$document->author}}</span>
                    </div>
                </div>
                <div class="mt-4">
                    <div>
                        <span class="fw-bold">Orientador:</span>
                    </div>
                    <div>
                        <span>{{$document->advisor}}</span>
                    </div>
                </div>
                <div class="mt-4">
                    <div>
                        <span class="fw-bold">Data de publicação:</span>
                    </div>
                    <div>
                        <span>{{$document->getCreatedAttribute()}}</span>
                    </div>
                </div>
                <div class="mt-4">
                    <div>
                        <span class="fw-bold">Resumo:</span>
                    </div>
                    <div>
                        <span>{{$document->abstract}}</span>
                    </div>
                </div>
                <div class="mt-4">
                    <div>
                        <span class="fw-bold">Palavras chave:</span>
                    </div>
                    <ul>
                        @foreach (explode(',', $document->keyword) as $keyword)
                            <li>
                                <span>{{$keyword}}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <div class="mt-4">
                    <div>
                        <span class="fw-bold">Descritores:</span>
                    </div>
                    <ul>
                        @foreach (explode(',', $document->descriptor) as $descriptor)
                            <li>
                                <span>{{$descriptor}}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <div class="mt-4">
                    <div>
                        <span class="fw-bold">Tipo de documento:</span>
                    </div>
                    <div>
                        <span>{{$document->documentType}}</span>
                    </div>
                </div>
                <div class="mt-4">
                    <div>
                        <span class="fw-bold">Arquivo:</span>
                    </div>
                    <div>
                        <span><a href="/storage/{{$document->document}}">Visualizar arquivo</a></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
