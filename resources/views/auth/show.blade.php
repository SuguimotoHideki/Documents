@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            @can('manage any user')
            <h1 class='fs-2'>Informações do usuário</h1>
            @else
            <h1 class='fs-2'>Minhas informações</h1>
            @endcan
            <div class="shadow-sm p-3 mb-5 bg-white">
                <nav class="mb-3 navbar navbar-expand navbar-light bg-white py-0 border-bottom">
                    <div class="navbar-nav me-auto">
                        <a href="{{route('editUser', $user)}}" class="nav-item nav-link">Editar Informações</a>
                        <a href="{{route('editPassword', $user)}}" class="nav-item nav-link">Alterar Senha</a>
                    </div>
                </nav>
                <div class="mt-3">
                    <div class="fw-bold">Nome:</div>
                    <div>{{$user->user_name}}</div>
                </div>
                <div class="mt-3">
                    <div class="fw-bold">CPF:</div>
                    <div>{{$user->cpf}}</div>
                </div>
                <div class="mt-3">
                    <div class="fw-bold">Data de nascimento:</div>
                    <div>{{$user->getBirthDate()}}</div>
                </div>
                <div class="mt-3">
                    <div class="fw-bold">Endereço de e-mail:</div>
                    <div>{{$user->user_email}}</div>
                </div>
                <div class="mt-3">
                    <div class="fw-bold">Número de telefone:</div>
                    <div>{{$user->user_phone_number}}</div>
                </div>
                <div class="mt-3">
                    <div class="fw-bold">Instituição:</div>
                    <div>{{$user->user_institution}}</div>
                </div>
                @can('manage any user')
                <div class="mt-3">
                    <div class="fw-bold">Papel:</div>
                    <div>{{$user->getRoles->value('name')}}</div>
                </div>
                @endcan
            </div>
        </div>
    </div>
</div>
@endsection
