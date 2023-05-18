@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            @if(count($documents) == 0)
                <div class="text-center">
                    <p>Não há documentos publicados.</p>
                    <a href="/documents/create">
                        <button type="submit" class="btn btn-primary bg-blue-600 mt-4">
                            {{ __('Publicar Documento') }}
                        </button>
                    </a>
                </div>
            @else
                <div class="list-group list-group-flush shadow-sm p-3 mb-5 bg-white">
                    <div class="table-responsive">
                        <table class="table bg-white">
                            <colgroup>
                                <col width="10%">
                                <col width="30%">
                                <col width="20%">
                                <col width ="20%">
                                <col width ="20%">
                            </colgroup>
                            <tr>
                                <th id="t1">Data de publicação</th>
                                <th id="t2">Título</th>
                                <th id="t3">Autor</th>
                                <th id="t4">Palavras chave</th>
                                <th id="t5">Ações</th>
                            </tr>
                            @foreach ($documents as $document)
                                <tr>
                                    <td headers="t1">{{$document->getCreatedAttribute()}}</td>
                                    <td headers="t2"><a href="/documents/{{$document->id}}">{{$document->title}}</a></td>
                                    <td headers="t3">{{$document->author}}</td>
                                    <td headers="t4">{{$document->keyword}}</td>
                                    @can('manage document')
                                    <td headers="t5">
                                        <a href="/documents/{{$document->id}}" class="btn btn-primary bg-blue-600 ml-4">View</a>
                                        <a href="/documents/{{$document->id}}/edit" class="btn btn-primary bg-blue-600 ml-4">Edit</a>
                                        <a href="/" class="btn btn-danger bg-red-600">Delete</a>
                                    </td>
                                    @endcan
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
