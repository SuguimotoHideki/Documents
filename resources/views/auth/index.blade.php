@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="list-group list-group-flush shadow-sm p-3 mb-5 bg-white">
                <div class="table-responsive">
                    <table class="table bg-white">
                        <colgroup>
                            <col width="20%">
                            <col width="10%">
                            <col width="15%">
                            <col width ="10%">
                            <col width="10%">
                            <col width="25%">
                        </colgroup>
                        <tr>
                            <th id="t1">Nome completo</th>
                            <th id="t2">CPF</th>
                            <th id="t3">E-mail</th>
                            <th id="t4">Telefone</th>
                            <th id="t5">Papel</th>
                            <th id="t6">Ações</th>
                        </tr>
                        @foreach ($users as $user)
                            <tr>
                                <td headers="t1"><a href="/users/{{$user->id}}">{{$user->user_name}}</td>
                                <td headers="t2">{{$user->cpf}}</a></td>
                                <td headers="t3">{{$user->user_email}}</td>
                                <td headers="t4">{{$user->user_phone_number}}</td>
                                <td headers="t5">{{$user->getRoles->value('name')}}</td>
                                <td headers="t6">
                                    <a href="/users/{{$user->id}}" class="btn btn-primary bg-blue-600 ml-4">View</a>
                                    <a href="/users/{{$user->id}}/edit" class="btn btn-primary bg-blue-600 ml-4">Edit</a>
                                    <a href="/" class="btn btn-danger bg-red-600">Delete</a>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
