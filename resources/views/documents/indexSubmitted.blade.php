@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="row mb-3">
                <h1 class='fs-2 col'>Minhas submissões</h1>
                @if($documents->count() > 0)
                    <div class="col">
                        <a href="{{route('createDocument')}}" class="btn btn-success float-end">Submeter documento</a>
                    </div>
                @endif
            </div>
            @if($documents->count() === 0)
                <div class="text-center">
                    <p>Ainda não há submissões.</p>
                    <a href="{{route('createDocument')}}">
                        <button type="submit" class="btn btn-success bg-blue-600 mt-4">
                            {{ __('Submeter documento') }}
                        </button>
                    </a>
                </div>
            @else
                <div class="list-group list-group-flush shadow-sm p-3 mb-5 bg-white">
                    <div class="table-responsive">
                        <table class="table bg-white">
                            <colgroup>
                                <col width="5%">
                                <col width="20%">
                                <col width="15%">
                                <col width ="15%">
                                <col width ="15%">
                                <col width ="15%">
                                <col width ="15%">
                            </colgroup>
                            <thead>
                                <tr class="align-middle">
                                    <th id="t1">@sortablelink('id', 'ID')</th>
                                    <th id="t2">@sortablelink('title', 'Título')</th>
                                    <th id="t3">@sortablelink(Auth::user()->user_name, 'Autor correspondente')</th>
                                    <th id="t4">@sortablelink('document_institution', 'Instituição')</th>
                                    <th id="t5">@sortablelink('document_type', 'Tipo')</th>
                                    <th id="t6">@sortablelink('created_at', 'Criado em')</th>
                                    <th id="t7">@sortablelink('updated_at', 'Atualizado em')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($documents as $document)
                                <tr class="align-middle">
                                    <td headers="t1"><a href="{{route('showDocument', $document)}}">{{$document->id}}</a></td>
                                    <td headers="t2"><a href="{{route('showDocument', $document)}}">{{$document->title}}</a></td>
                                    <td headers="t3">{{Auth::user()->user_name}}</td>
                                    <td headers="t4">{{$document->document_institution}}</td>
                                    <td headers="t5">{{$document->document_type}}</td>
                                    <td headers="t6">{{$document->formatDate($document->created_at)}}</td>
                                    <td headers="t7">{{$document->formatDate($document->updated_at)}}</td>
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
