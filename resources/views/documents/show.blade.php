@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <h1 class="fs-3 fw-bold text-uppercase text-center mb-3">{{$document->title}}</h1>
        <div class="col-md-9">
            <div class="shadow-sm p-3 mb-5 bg-white">
                <x-document-nav-menu :document="$document"/>
                <div class="row">
                    <div class="text-muted">Submissão nº: {{$document->submission->id}}</div>
                </div>
                <div class="mt-3 text-break">
                    <h2 class="fs-5 fw-bold text-start">Resumo:</h2>
                    <div>{{$document->abstract}}</div>
                </div>
                <div class="row">
                    <div class="col-md mt-3">
                        <h2 class="fs-5 fw-bold">Instituição:</h2>
                        <div>{{$document->document_institution}}</div>
                    </div>
                    <div class="col-md mt-3">
                        <h2 class="fs-5 fw-bold">Tipo de documento:</h2>
                        <div>{{$document->document_type}}</div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md mt-3">
                        <h2 class="fs-5 fw-bold">Evento:</h2>
                        <div><a href="{{ route('showEvent', $document->submission->event)}}">{{$document->submission->event->event_name}}</a></div>
                    </div>
                    <div class="col-md mt-3">
                        <h2 class="fs-5 fw-bold">Status:</h2>
                        <div>{{$document->submission->getStatusValue()}}</div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md mt-3">
                        <h2 class="fs-5 fw-bold">Autores:</h2>
                        <ul class="mb-0">
                            <li>{{$document->submission->user->user_name}} (Correspondente)</li>
                            @foreach ($document->coAuthors as $coAuthor)
                                <li>{{$coAuthor->formatName($coAuthor->name)}}</li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="col-md mt-3">
                        <h2 class="fs-5 fw-bold">Palavras-chave:</h2>
                        <x-list-items : wordList="{{$document->keyword}}"/>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="shadow-sm p-3 mb-3 bg-white">
                <h2 class="fs-5 fw-bold mt-3">
                    <i class="fa-regular fa-clock"></i> Enviado em:</h2>
                <div class="mt-2">{{$document->formatDate($document->created_at)}}</div>
                <h2 class="fs-5 fw-bold mt-3">
                    <i class="fa-regular fa-clock"></i> Atualizado em:</h2>
                <div class="mt-2">{{$document->formatDate($document->updated_at)}}</div>
                <h2 class="fs-5 fw-bold mt-3">
                    <i class="fa-regular fa-clock"></i> Aprovado em:</h2>
                <div class="mt-2">{{$document->submission->formatDate($document->submission->approved_at)}}</div>
            </div>
            <div class="shadow-sm p-3 mb-3 bg-white">
                <h2 class="fs-5 fw-bold mt-3">
                    <i class="fa-regular fa-file"></i> Visualizar arquivo:</h2>
                <div class="mt-2"><a href="/storage/{{$document->document}}">Clique aqui para abrir o arquivo</a></div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="documentDeletePrompt{{$document->id}}" tabindex="-1" aria-labelledby="documentDeletePromptLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Excluir submissão</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Deseja excluir a submissão <strong>{{$document->title}}</strong> do evento <strong>{{$document->submission->event->event_name}}</strong> ?</p>

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

@endsection
