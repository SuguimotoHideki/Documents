@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Editar Informações') }}</div>
                <form method="POST" action="/users/{{$user->id}}/update">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="row mb-3">
                            <label for="user_name" class="col-md-4 col-form-label text-md-end">{{ __('Nome completo') }}
                                <span style="color: red">*</span>
                            </label>

                            <div class="col-md-6">
                                <input id="user_name" type="text" class="form-control @error('user_name') is-invalid @enderror" name="user_name" value="{{ old('user_name', $user->user_name) }}" required autocomplete="user_name" autofocus>

                                @error('user_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="cpf" class="col-md-4 col-form-label text-md-end">{{ __('CPF') }}
                                <span style="color: red">*</span>
                            </label>

                            <div class="col-md-6">
                                <input id="cpf" type="text" maxlength="11" placeholder="Digite apenas os números" class="form-control @error('cpf') is-invalid @enderror" name="cpf" value="{{ old('cpf', $user->cpf) }}" required autocomplete="cpf" autofocus>

                                @error('cpf')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="birth_date" class="col-md-4 col-form-label text-md-end">{{ __('Data de nascimento') }}
                                <span style="color: red">*</span>
                            </label>

                            <div class="col-md-6 my-auto">
                                <input id="birth_date" type="date" class="form-control @error('birth_date') is-invalid @enderror" name="birth_date" value="{{ old('birth_date', $user->birth_date) }}" required autocomplete="birth_date" autofocus>

                                @error('birth_date')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="user_email" class="col-md-4 col-form-label text-md-end">{{ __('Endereço de e-mail') }}
                                <span style="color: red">*</span>
                            </label>

                            <div class="col-md-6 my-auto">
                                <input id="user_email" type="user_email" class="form-control @error('user_email') is-invalid @enderror" name="user_email" value="{{ old('user_email', $user->user_email) }}" required autocomplete="user_email">

                                @error('user_email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="user_phone_number" class="col-md-4 col-form-label text-md-end">{{ __('Número de telefone') }}
                                <span style="color: red">*</span>
                            </label>

                            <div class="col-md-6 my-auto">
                                <input id="user_phone_number" type="text" maxlength="11" placeholder="Digite apenas os números" class="form-control @error('user_phone_number') is-invalid @enderror" name="user_phone_number" value="{{ old('user_phone_number', $user->user_phone_number) }}" required autocomplete="user_phone_number">

                                @error('user_phone_number')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="user_institution" class="col-md-4 col-form-label text-md-end">{{ __('Instituição') }}
                                <span style="color: red">*</span>
                            </label>

                            <div class="col-md-6 my-auto">
                                <input id="user_institution" type="text" class="form-control @error('user_institution') is-invalid @enderror" name="user_institution" value="{{ old('user_institution', $user->user_institution) }}" required autocomplete="user_institution">

                                @error('user_institution')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        @can('update any user', Auth::user())
                            <div class="row mb-3">
                                <label for="current-password" class="col-md-4 col-form-label text-md-end">{{ __('Senha') }}
                                <span style="color: red">*</span>
                            </label>

                                <div class="col-md-6">
                                    <input id="current-password" type="password" class="form-control" name="current_password" disabled>
                                </div>
                            </div>
                        @else
                            <div class="row mb-3">
                                <label for="current-password" class="col-md-4 col-form-label text-md-end">{{ __('Senha') }}
                                <span style="color: red">*</span>
                            </label>

                                <div class="col-md-6">
                                    <input id="current-password" type="password" class="form-control @error('current_password') is-invalid @enderror" name="current_password" required autocomplete="new-password">

                                    @error('current_password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                <small class="form-text text-muted">Confirme sua senha para salvar as alterações</small>
                                </div>
                            </div>
                        @endcan
                    </div>
                    <div class="modal fade" id="editPrompt" tabindex="-1" aria-labelledby="editPromptLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Salvar alterações</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <p>Deseja confirmar as alterações ?</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                    <form action="{{ route('updateUser', $user)}}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="btn btn-primary">
                                            {{ __('Salvar') }}
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="card-footer">
                    <div class="row">
                        <div class="d-grid col-5 mx-auto">
                            <button type="submit" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#editPrompt">
                                {{ __('Salvar alterações') }}
                            </button>
                        </div>
                        <div class="d-grid col-5 mx-auto">
                            <a href="{{ url()->previous() }}" class="btn btn-outline-dark">
                                Voltar
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
