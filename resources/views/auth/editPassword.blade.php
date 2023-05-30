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
                        <div class="row mb-3">
                            <label for="current-password" class="col-md-4 col-form-label text-md-end">{{ __('Senha atual') }}</label>

                            <div class="col-md-6">
                                <input id="current-password" type="password" class="form-control @error('current_password') is-invalid @enderror" name="current_password" required autocomplete="new-password">

                                @error('current_password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="new-password" class="col-md-4 col-form-label text-md-end">{{ __('Nova senha') }}</label>

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
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('Confirme a nova senha') }}</label>

                            <div class="col-md-6 my-auto">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="justify-content-center text-center">
                            <button type="submit" class="btn btn-primary bg-blue-600">
                                {{ __('Atualizar senha') }}
                            </button>
                            <div class="btn">
                                <a href="/users/{{$user->id}}" class="text-black ml-4">Voltar</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
