@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-9">
            <div class="card">
                <div class="card-header fw-bold fs-5">{{ __('Tipos de submissão') }}</div>
                <div class="list-group list-group-flush px-3 shadow-sm">
                    <div class="table-responsive">
                        <table class="table table-bordered border-light table-hover">
                            <div class="row my-2 mx-0">
                                <div class="col-md-9 my-auto">
                                    <div class="text-muted"><i class="fa-regular fa-circle-question"></i> Gerenciar os tipos de submissão, os itens abaixo estarão disponíveis para todos os eventos.</div>
                                </div>
                                <div class="col-md-3 my-auto text-end">
                                    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#typeCreatePrompt">
                                        Criar tipo
                                    </button>
                                </div>
                            </div>
                            <colgroup>
                                <col width="75%">
                                <col width="25%">
                            </colgroup>
                            <thead class="table-light">
                                <tr class="align-middle">
                                    <th id="t1">Tipo</th>
                                    <th id="t2">Operações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($types as $type)
                                    <tr class="align-middle" style="height:4rem">
                                        <td headers="t1">{{ucfirst($type->name)}}</td>
                                        <td headers="t2">
                                            <div class="nav-item dropdown">
                                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                                    Operações
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                                    <button type="button" class="dropdown-item btn rounded-0" data-bs-toggle="modal" data-bs-target="#typeEditPrompt{{$type->id}}">
                                                        Editar tipo
                                                    </button>
                                                    <button type="button" class="dropdown-item btn rounded-0" data-bs-toggle="modal" data-bs-target="#typeDeletePrompt{{$type->id}}">
                                                        Excluir tipo
                                                    </button>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <div class="modal fade" id="typeDeletePrompt{{$type->id}}" tabindex="-1" aria-labelledby="typeDeletePromptLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Excluir tipo de submissão</h5>
                                            </div>
                                            @if(!$type->events->isEmpty())
                                                <div class="modal-body">
                                                    <p>Os seguintes eventos utilizam o tipo <strong>{{ucfirst($type->name)}}</strong>, desmarque-as para permitir a exclusão:</p>
                                                    <ul>
                                                        @foreach($type->events as $event)
                                                        <li>
                                                            {{$event->name}}
                                                        </li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">OK</button>
                                                </div>
                                            @else
                                                <div class="modal-body">
                                                    <p>Deseja excluir o tipo de submissão <strong>{{ucfirst($type->name)}}</strong> ?</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                    <form action="{{ route('deleteSubType', $type)}}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger">
                                                            {{ __('Excluir') }}
                                                        </button>
                                                    </form>
                                                </div>
                                            @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal fade" id="typeCreatePrompt" tabindex="-1" aria-labelledby="typeCreatePromptLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <form action="{{ route('createSubType')}}" method="POST">
                                                @csrf
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Criar tipo de submissão</h5>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="row my-2">
                                                            <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Tipo de submissão') }}
                                                                <span style="color: red">*</span>
                                                            </label>
                                
                                                            <div class="col-md-6 my-auto">
                                                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" required autocomplete="name">
                                
                                                                @error('name')
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong>{{ $message }}</strong>
                                                                    </span>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                        <button type="submit" class="btn btn-success">
                                                            {{ __('Criar') }}
                                                        </button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="modal fade" id="typeEditPrompt{{$type->id}}" tabindex="-1" aria-labelledby="typeEditPromptLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <form action="{{ route('updateSubType', $type)}}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Editar tipo de submissão</h5>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p class="text-muted"><i class="fa-regular fa-circle-question"></i> A alteração irá modificar todos os eventos e submissões que utilizem esse tipo.</p>
                                                        <div class="row my-2">
                                                            <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Tipo de submissão') }}
                                                                <span style="color: red">*</span>
                                                            </label>
                                
                                                            <div class="col-md-6 my-auto">
                                                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" value="{{ucfirst($type->name)}}" name="name" required autocomplete="name">
                                
                                                                @error('name')
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong>{{ $message }}</strong>
                                                                    </span>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                        <button type="submit" class="btn btn-success">
                                                            {{ __('Salvar') }}
                                                        </button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div> 
            </div>
        </div>
    </div>
</div>
@endsection
