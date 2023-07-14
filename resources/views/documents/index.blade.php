@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <h1 class='fs-2 col'>Gerenciar submissões</h1>
            @if($documents->count() === 0)
                <div class="text-center">
                    <p>Ainda não há submissões.</p>
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
                                    <th id="t4">@sortablelink('document_type', 'Tipo')</th>
                                    <th id="t5">@sortablelink('created_at', 'Criado em')</th>
                                    <th id="t6">@sortablelink('updated_at', 'Atualizado em')</th>
                                    <th id="t7">Operações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($documents as $document)
                                <tr class="align-middle">
                                    <td headers="t1"><a href="{{route('showDocument', $document)}}">{{$document->id}}</a></td>
                                    <td headers="t2"><a href="{{route('showDocument', $document)}}">{{$document->title}}</a></td>
                                    <td headers="t3">{{Auth::user()->user_name}}</td>
                                    <td headers="t4">{{$document->document_type}}</td>
                                    <td headers="t5">{{$document->formatDate($document->created_at)}}</td>
                                    <td headers="t6">{{$document->formatDate($document->updated_at)}}</td>
                                    <td headers="t7">
                                        <div class="nav-item dropdown">
                                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                                Operações
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                                <a class="dropdown-item" href="{{route('showDocument', $document)}}">
                                                    Visualizar
                                                </a>
    
                                                <a class="dropdown-item" href="{{route('editDocument', $document)}}">
                                                    Editar
                                                </a>
    
                                                <button type="button" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#documentDeletePrompt{{$document}}">
                                                    Excluir
                                                </button>
                                            </div>
                                        </div>
                                    </td>
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
