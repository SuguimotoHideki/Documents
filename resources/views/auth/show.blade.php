@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="shadow-sm p-3 mb-5 bg-white">
                <nav class="mb-3 navbar navbar-expand navbar-light bg-white py-0 border-bottom">
                        <div class="navbar-nav me-auto">
                            <a href="/users/{{$user->id}}/edit" class="nav-item nav-link">Editar Informações</a>
                            <a href="/users/{{$user->id}}/edit-password" class="nav-item nav-link">Alterar Senha</a>
                        </div>
                </nav>
                <div class="mb-3">
                    <div>
                        <span class="fw-bold">Nome:</span>
                    </div>
                    <div>
                        <span>{{$user->user_name}}</span>
                    </div>
                </div>
                <div class="mb-3">
                    <div>
                        <span class="fw-bold">CPF:</span>
                    </div>
                    <div>
                        <span>{{$user->cpf}}</span>
                    </div>
                </div>
                <div class="mb-3">
                    <div>
                        <span class="fw-bold">Data de nascimento:</span>
                    </div>
                    <div>
                        <span>{{$user->getBirthDate()}}</span>
                    </div>
                </div>
                <div class="mb-3">
                    <div>
                        <span class="fw-bold">Número de telefone:</span>
                    </div>
                    <div>
                        <span>{{$user->user_phone_number}}</span>
                    </div>
                </div>
                <div class="mb-3">
                    <div>
                        <span class="fw-bold">Endereço de e-mail:</span>
                    </div>
                    <div>
                        <span>{{$user->user_email}}</span>
                    </div>
                </div>
                @can('manage any user')
                <div class="mb-3">
                    <div>
                        <span class="fw-bold">Papel:</span>
                    </div>
                    <div>
                        <span>{{$user->getRoles->value('name')}}</span>
                    </div>
                </div>
                @endcan
            </div>
        </div>
    </div>
</div>
@endsection
