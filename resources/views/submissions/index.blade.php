@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="row mb-3">
                <h1 class='fs-2 col'>Minhas submissões</h1>
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
                    <table class="table table-bordered border-light table-hover bg-white">
                            <colgroup>
                                <col width="4%">
                                <col width="20%">
                                <col width="20%">
                                <col width ="10%">
                                <col width ="10%">
                                <col width ="12%">
                                <col width ="12%">
                                <col width ="12%">
                            </colgroup>
                            <thead class="table-light">
                                <tr class="align-middle">
                                    <th id="t1">@sortablelink('id', 'ID')</th>
                                    <th id="t2">
                                        <a href="{{ route('indexSubmissions', ['user' => $user, 'sort' => 'document.title', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc'])}}">Título</a>
                                        @if(request('sort') === 'document.title')
                                            <i class="{{request('direction') === 'asc' ? 'fa-solid fa-arrow-down-a-z' : 'fa-solid fa-arrow-down-z-a'}}"></i>
                                        @else
                                            <i class="fa fa-sort"></i>
                                        @endif
                                    </th>
                                    <th id="t3">
                                        <a href="{{ route('indexSubmissions', ['user' => $user, 'sort' => 'event.event_name', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc'])}}">Evento</a>
                                        @if(request('sort') === 'event.event_name')
                                            <i class="{{request('direction') === 'asc' ? 'fa-solid fa-arrow-down-a-z' : 'fa-solid fa-arrow-down-z-a'}}"></i>
                                        @else
                                            <i class="fa fa-sort"></i>
                                        @endif
                                    </th>
                                    <th id="t4">
                                        <a href="{{ route('indexSubmissions', ['user' => $user, 'sort' => 'document.document_type', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc'])}}">Tipo</a>
                                        @if(request('sort') === 'document.document_type')
                                            <i class="{{request('direction') === 'asc' ? 'fa-solid fa-arrow-down-a-z' : 'fa-solid fa-arrow-down-z-a'}}"></i>
                                        @else
                                            <i class="fa fa-sort"></i>
                                        @endif
                                    </th>
                                    <th id="t5">@sortablelink('status', 'Status')</th>
                                    <th id="t6">@sortablelink('approved_at','Aprovado em')</th>
                                    <th id="t7">@sortablelink('created_at','Publicado em')</th>
                                    <th id="t8">@sortablelink('updated_at', 'Atualizado em')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($submissions as $submission)
                                <tr class="align-middle" style="height:4rem">
                                    <td headers="t1"><a href="{{ route('showDocument', $submission->document)}}">{{$submission->id}}</a></td>
                                    <td headers="t2"><a href="{{ route('showDocument', $submission->document)}}">{{$submission->document->title}}</a></td>
                                    <td headers="t3"><a href="{{ route('showEvent', $submission->event)}}">{{$submission->event->event_name}}</a></td>
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
