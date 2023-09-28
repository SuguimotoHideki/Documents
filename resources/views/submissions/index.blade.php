@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="row mb-2">
                @if (Auth::user()->id === $user->id)
                    <h1 class='fs-2 col'>Minhas submissões</h1>
                @else
                    <h1 class='fs-2'>Submissões de {{$user->user_name}}</h1>
                @endif
            </div>
            @if($submissions->count() === 0)
                <div class="text-center">
                    <div class="row mb-2">
                        @if (Auth::user()->id === $user->id)
                            <p>Ainda não há submissões. Inscreva-se em um evento para fazer uma submissão.</p>
                            <a href="/">
                                <button type="submit" class="btn btn-success bg-blue-600 mt-4">
                                    {{ __('Ver eventos') }}
                                </button>
                            </a>
                        @else
                            <p>Ainda não há submissões desse usuário.</p>
                        @endif
                </div>
            @else
            <div class="list-group list-group-flush shadow-sm p-3 mb-5 bg-white">
                <div class="table-responsive">
                    <table class="table table-bordered border-light table-hover bg-white table-fixed">
                            <colgroup>
                                <col width="12%">
                                <col width="12%">
                                <col width="25%">
                                <col width ="15%">
                                <col width ="12%">
                                <col width ="12%">
                                <col width ="10%">
                            </colgroup>
                            <thead class="table-light">
                                <tr class="align-middle">
                                    <th id="t1">@sortablelink('document.id', 'Número')</th>
                                    <th id="t3">@sortablelink('document.type', 'Modalidade')</th>
                                    <th id="t2">@sortablelink('document.title', 'Título')</th>
                                    <th id="t4">@sortablelink('status', 'Status')</th>
                                    <th id="t5">Avaliações</th>
                                    <th id="t6">@sortablelink('event.name', 'Evento')</th>
                                    <th id="t7">Operações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($submissions as $submission)
                                @php
                                    $status = $submission->getStatusID()
                                @endphp
                                <tr class="align-middle" style="height:4rem">
                                    <td headers="t1"><a href="{{ route('showDocument', $submission->document)}}">{{$submission->id}}</a></td>
                                    <td headers="t2">{{ucfirst($submission->document->submissionType->name)}}</td>
                                    <td headers="t3" class="text-truncate"><a href="{{ route('showDocument', $submission->document)}}">{{$submission->document->title}}</a></td>
                                    <td headers="t4">
                                        @if($status === 0)
                                            <div class="bg-success text-white mx-3 py-1 rounded-2 text-center">
                                                {{$submission->getStatusValue()}}
                                            </div>
                                        @elseif($status === 1)
                                            <div class="bg-danger text-white mx-3 py-1 rounded-2 text-center">
                                                {{$submission->getStatusValue()}}
                                            </div>
                                        @elseif($status === 2)
                                            <div class="bg-warning mx-3 py-1 rounded-2 text-center">
                                                {{$submission->getStatusValue()}}
                                            </div>
                                        @else
                                            <div class="bg-primary text-white mx-3 py-1 rounded-2 text-center">
                                                {{$submission->getStatusValue()}}
                                            </div>
                                        @endif
                                    </td>
                                    <td headers="t5"><a href="{{ route('indexByDocument', $submission->document)}}">Ver avaliações</a></td>
                                    <td headers="t6"><a href="{{ route('showEvent', $submission->event)}}">{{$submission->event->name}}</a></td>
                                    <td headers="t7">
                                        <div class="nav-item dropdown">
                                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                                Operações
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                                <a class="dropdown-item btn rounded-0" href="{{route('editDocument', $submission->document)}}">
                                                    Editar
                                                </a>
                                                <button type="button" class="dropdown-item btn rounded-0" data-bs-toggle="modal" data-bs-target="#documentDeletePrompt{{$submission->document->id}}">
                                                    Excluir
                                                </button>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <div class="modal fade" id="documentDeletePrompt{{$submission->document->id}}" tabindex="-1" aria-labelledby="documentDeletePromptLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Excluir submissão</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <p>Deseja excluir a submissão ?</p>
                                                <p>Essa operação não pode ser desfeita.</p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                <form action="{{ route('deleteDocument', $submission->document->id)}}" method="POST">
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
