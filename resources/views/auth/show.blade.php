@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <x-user-nav-menu :user="$user"/>
        <div class="col-md-9 h-100">
            @can('manage any user')
            <h1 class='fs-2'>Informações do usuário</h1>
            @else
            <h1 class='fs-2'>Minhas informações</h1>
            @endcan
            <div class="shadow-sm p-3 bg-white">
                <div>
                    <div class="fw-bold fs-default">Nome:</div>
                    <div>{{$user->user_name}}</div>
                </div>
                <div class="mt-3">
                    <div class="fw-bold fs-default">CPF:</div>
                    <div>{{$user->cpf}}</div>
                </div>
                <div class="mt-3">
                    <div class="fw-bold fs-default">Data de nascimento:</div>
                    <div>{{$user->getBirthDate()}}</div>
                </div>
                <div class="mt-3">
                    <div class="fw-bold fs-default">Endereço de e-mail:</div>
                    <div>{{$user->user_email}}</div>
                </div>
                <div class="mt-3">
                    <div class="fw-bold fs-default">Número de telefone:</div>
                    <div>{{$user->user_phone_number}}</div>
                </div>
                <div class="mt-3">
                    <div class="fw-bold fs-default">Instituição:</div>
                    <div>{{$user->user_institution}}</div>
                </div>
                @can('manage any user')
                <div class="mt-3">
                    <div class="fw-bold fs-default">Papel:</div>
                    <div>{{ucfirst($user->getRoleNames()->first())}}</div>
                </div>
                @endcan
            </div>
        </div>
    </div>
</div>
@endsection
