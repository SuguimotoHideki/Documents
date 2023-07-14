@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Register') }}</div>
                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    <div class="card-body">
                        <div class="row mb-3">
                            <label for="user_name" class="col-md-4 col-form-label text-md-end">{{ __('Nome completo') }}
                                <span style="color: red">*</span>
                            </label>

                            <div class="col-md-6">
                                <input id="user_name" type="text" class="form-control @error('user_name') is-invalid @enderror" name="user_name" value="{{ old('user_name') }}" required autocomplete="user_name" autofocus>

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
                                <input id="cpf" type="text" maxlength="11" placeholder="Digite apenas os números" class="form-control @error('cpf') is-invalid @enderror" name="cpf" value="{{ old('cpf') }}" required autocomplete="cpf" autofocus>

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
                                <input id="birth_date" type="date" class="form-control @error('birth_date') is-invalid @enderror" name="birth_date" value="{{ old('birth_date') }}" required autocomplete="birth_date" autofocus>

                                @error('birth_date')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3 ">
                            <label for="user_email" class="col-md-4 col-form-label text-md-end">{{ __('Endereço de e-mail') }}
                                <span style="color: red">*</span>
                            </label>

                            <div class="col-md-6 my-auto">
                                <input id="user_email" type="user_email" class="form-control @error('user_email') is-invalid @enderror" name="user_email" value="{{ old('user_email') }}" required autocomplete="user_email">

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
                                <input id="user_phone_number" type="text" maxlength="11" placeholder="Digite apenas os números" class="form-control @error('user_phone_number') is-invalid @enderror" name="user_phone_number" value="{{ old('user_phone_number') }}" required autocomplete="user_phone_number">

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
                                <input id="user_institution" type="text" class="form-control @error('user_institution') is-invalid @enderror" name="user_institution" value="{{ old('user_institution') }}" required autocomplete="user_institution">

                                @error('user_institution')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Senha') }}
                                <span style="color: red">*</span>
                            </label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('Confirme a senha') }}
                                <span style="color: red">*</span>
                            </label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="d-grid col-5 mx-auto">
                                <button type="submit" class="btn btn-success">
                                    {{ __('Register') }}
                                </button>
                            </div>
                            <div class="d-grid col-5 mx-auto">
                                <a href="{{ route('login') }}" class="btn btn-outline-dark">
                                    {{ __('Cancel') }}
                                </a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
