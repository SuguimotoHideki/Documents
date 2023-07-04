@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <h1 class='fs-2'>Gerenciar usuários</h1>
            <div class="list-group list-group-flush shadow-sm p-3 mb-5 bg-white">
                <div class="table-responsive">
                    <table class="table bg-white">
                        <colgroup>
                            <col width="20%">
                            <col width="20%">
                            <col width="20%">
                            <col width ="20%">
                            <col width="10%">
                            <col width="10%">
                        </colgroup>
                        <thead class="align-middle">
                            <tr>
                                <th id="t1">Nome completo</th>
                                <th id="t2">CPF</th>
                                <th id="t3">E-mail</th>
                                <th id="t4">Telefone</th>
                                <th id="t5">Papel</th>
                                <th id="t6">Operações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                            <tr class="align-middle" style="height: 4rem">
                                <td headers="t1"><a href="/users/{{$user->id}}">{{$user->user_name}}</td>
                                <td headers="t2">{{$user->cpf}}</a></td>
                                <td headers="t3">{{$user->user_email}}</td>
                                <td headers="t4">{{$user->user_phone_number}}</td>
                                <td headers="t5">{{$user->getRoles->value('name')}}</td>
                                <td headers="t6">
                                    <div class="nav-item dropdown">
                                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                            Operações
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                            <a class="dropdown-item" href="/users/{{$user->id}}">
                                                Visualizar
                                            </a>

                                            <a class="dropdown-item" href="/users/{{$user->id}}/edit">
                                                Editar
                                            </a>

                                            <button type="button" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#eventDeletePrompt{{$user->id}}">
                                                Excluir
                                            </button>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <div class="modal fade" id="eventDeletePrompt{{$user->id}}" tabindex="-1" aria-labelledby="eventDeletePromptLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Excluir usuário</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p>Deseja excluir o usuário {{$user->user_name}} ?</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                        <form action="{{ route('deleteEvent', $user->id)}}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-primary">
                                                {{ __('Excluir') }}
                                            </button>
                                        </form>
                                    </div>
                                    </div>
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
@endsection
