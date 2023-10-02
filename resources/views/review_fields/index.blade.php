@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-9">
            <div class="card">
                <div class="card-header fw-bold fs-5">{{ __('Critérios de avaliação') }}</div>
                <div class="list-group list-group-flush px-3 shadow-sm">
                    <div class="table-responsive">
                        <table class="table table-bordered border-light table-hover">
                            <div class="row my-2 mx-0">
                                <div class="col-md-9 my-auto">
                                    <div class="text-muted"><i class="fa-regular fa-circle-question"></i> Gerenciar os critérios de avaliação.</div>
                                </div>
                                <div class="col-md-3 my-auto text-end">
                                    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#fieldCreatePrompt">
                                        Criar critério
                                    </button>
                                </div>
                            </div>
                            <colgroup>
                                <col width="75%">
                                <col width="25%">
                            </colgroup>
                            <thead class="table-light">
                                <tr class="align-middle">
                                    <th id="t1">Critério</th>
                                    <th id="t2">Operações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($fields as $field)
                                    <tr class="align-middle" style="height:4rem">
                                        <td headers="t1">{{ucfirst($field->name)}}</td>
                                        <td headers="t2">
                                            <div class="nav-item dropdown">
                                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                                    Operações
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                                    <button type="button" class="dropdown-item btn rounded-0" data-bs-toggle="modal" data-bs-target="#fieldEditPrompt{{$field->id}}">
                                                        Editar campo
                                                    </button>
                                                    <button type="button" class="dropdown-item btn rounded-0" data-bs-toggle="modal" data-bs-target="#fieldDeletePrompt{{$field->id}}">
                                                        Excluir campo
                                                    </button>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <div class="modal fade" id="fieldDeletePrompt{{$field->id}}" tabindex="-1" aria-labelledby="fieldDeletePromptLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Excluir campo de avaliação</h5>
                                            </div>
                                                <div class="modal-body">
                                                    <p>Deseja excluir o campo de avaliação <strong>{{ucfirst($field->name)}}</strong> ?</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button field="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                    <form action="{{ route('deleteReviewField', $field)}}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button field="submit" class="btn btn-danger">
                                                            {{ __('Excluir') }}
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal fade" id="fieldEditPrompt{{$field->id}}" tabindex="-1" aria-labelledby="fieldEditPromptLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <form action="{{ route('updateReviewField', $field)}}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Editar campo de avaliação</h5>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="mx-5">
                                                            <div class="mb-3">
                                                                <label for="name">{{ __('Nome') }}
                                                                    <span style="color: red">*</span>
                                                                </label>
            
                                                                <div>
                                                                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ucfirst($field->name)}}" required autocomplete="name">
                                    
                                                                    @error('name')
                                                                        <span class="invalid-feedback" role="alert">
                                                                            <strong>{{ $message }}</strong>
                                                                        </span>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                            <div>
                                                                <label for="submission_type">{{ __('Tipos de submissão') }}
                                                                    <span style="color: red">*</span>
                                                                </label>
                                                                
                                                                <div id="submission_type" class="form-control @error('submission_type') is-invalid @enderror">
                                                                    @foreach($types as $type)
                                                                        <div>
                                                                            <input type="checkbox"  name="submission_type[]" value="{{$type->id}}" @checked($field->submissionTypes->contains($type->id))>
                                                                            <small>{{ ucfirst($type->name) }}</small>
                                                                        </div>
                                                                    @endforeach
                                                                </div>
                                                                <p class="text-muted">Escolha os tipos de submissão que terão esse critério de avaliação, mais de um tipo pode ser selecionado.</p>
            
                                                                @error('submission_type')
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
                        <div class="modal fade" id="fieldCreatePrompt" tabindex="-1" aria-labelledby="fieldCreatePromptLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <form action="{{ route('createReviewField')}}" method="POST">
                                    @csrf
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Criar campo de avaliação</h5>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mx-5">
                                                <div class="mb-3">
                                                    <label for="name">{{ __('Nome') }}
                                                        <span style="color: red">*</span>
                                                    </label>

                                                    <div>
                                                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" required autocomplete="name">
                        
                                                        @error('name')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div>
                                                    <label for="submission_type">{{ __('Tipos de submissão') }}
                                                        <span style="color: red">*</span>
                                                    </label>
                                                    
                                                    <div id="submission_type" class="form-control @error('submission_type') is-invalid @enderror">
                                                        @foreach($types as $type)
                                                            <div>
                                                                <input type="checkbox"  name="submission_type[]" value="{{$type->id}}">
                                                                <small>{{ ucfirst($type->name) }}</small>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                    <p class="text-muted">Escolha os tipos de submissão que terão esse critério de avaliação, mais de um tipo pode ser selecionado.</p>

                                                    @error('submission_type')
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
                    </div>
                </div> 
            </div>
        </div>
    </div>
</div>
@endsection
