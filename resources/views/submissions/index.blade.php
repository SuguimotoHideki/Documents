@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="row mb-3">
                <h1 class='fs-2 col'>Minhas submissões</h1>
                @if($submissions->count() > 0)
                    <div class="col">
                        <a href="" class="btn btn-success float-end">Submeter documento</a>
                    </div>
                @endif
            </div>
            @if($submissions->count() === 0)
                <div class="text-center">
                    <p>Ainda não há submissões. Inscreva-se em um evento para fazer uma submissão.</p>
                    <a href="/">
                        <button type="submit" class="btn btn-success bg-blue-600 mt-4">
                            {{ __('Ver eventos') }}
                        </button>
                    </a>
                </div>
            @else
                <div class="list-group list-group-flush shadow-sm p-3 mb-5 bg-white">
                    <div class="table-responsive">
                        <table class="table bg-white">
                            <colgroup>
                                <col width="10%">
                                <col width="20%">
                                <col width="20%">
                                <col width ="10%">
                                <col width ="10%">
                                <col width ="10%">
                                <col width ="10%">
                                <col width ="10%">
                            </colgroup>
                            <thead>
                                <tr class="align-middle">
                                    <th id="t1">ID</th>
                                    <th id="t2">Título</th>
                                    <th id="t3">Evento</th>
                                    <th id="t4">Tipo</th>
                                    <th id="t5">Status</th>
                                    <th id="t6">Aprovado em</th>
                                    <th id="t7">Publicado em</th>
                                    <th id="t8">Atualizado em</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($submissions as $submission)
                                <tr class="align-middle">
                                    <td headers="t1">{{$submission->id}}</td>
                                    <td headers="t2">{{$submission->document->title}}</td>
                                    <td headers="t3">{{$submission->event->event_name}}</td>
                                    <td headers="t4">{{$submission->document->document_type}}</td>
                                    <td headers="t5">{{$submission->getStatusValue()}}</td>
                                    <td headers="t6">{{$submission->formatDate($submission->approved_at)}}</td>
                                    <td headers="t7">{{$submission->formatDate($submission->created_at)}}</td>
                                    <td headers="t8">{{$submission->formatDate($submission->updated_at)}}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div> 
            @endif
        </div>
    </div>
</div>
@endsection
