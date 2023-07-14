@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Alterar Senha') }}</div>

                <div class="card-body">
                    <form method="POST" action="/users/{{$user->id}}/update-password">
                        @csrf
                        @method('PUT')
                        @can('update any user', Auth::user())
                            <div class="row mb-3">
                                <label for="current-password" class="col-md-4 col-form-label text-md-end">{{ __('Senha atual') }}
                                <span style="color: red">*</span>
                            </label>

                                <div class="col-md-6">
                                    <input id="current-password" type="password" class="form-control" name="current_password" disabled>
                                </div>
                            </div>
                        @else
                            <div class="row mb-3">
                                <label for="current-password" class="col-md-4 col-form-label text-md-end">{{ __('Senha atual') }}
                                <span style="color: red">*</span>
                            </label>

                                <div class="col-md-6">
                                    <input id="current-password" type="password" class="form-control @error('current_password') is-invalid @enderror" name="current_password" required autocomplete="new-password">

                                    @error('current_password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        @endcan
                        <div class="row mb-3">
                            <label for="new-password" class="col-md-4 col-form-label text-md-end">{{ __('Nova senha') }}
                                <span style="color: red">*</span>
                            </label>

                            <div class="col-md-6">
                                <input id="new-password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('Confirme a nova senha') }}
                                <span style="color: red">*</span>
                            </label>

                            <div class="col-md-6 my-auto">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>
                        <div class="modal fade" id="editPrompt" tabindex="-1" aria-labelledby="editPromptLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Salvar alterações</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p>Deseja confirmar a nova senha ?</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                        <form action="{{ route('editPassword', $user)}}" method="POST">
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
                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="d-grid col-5 mx-auto">
                            <button type="submit" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#editPrompt">
                                {{ __('Atualizar senha') }}
                            </button>
                        </div>
                        <div class="d-grid col-5 mx-auto">
                            <a href="{{ route('showUser', $user)}}" class="btn btn-outline-dark">
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
