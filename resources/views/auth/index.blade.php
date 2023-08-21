@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="row mb-2">
                <h1 class='fs-2 col'>Gerenciar usuários</h1>
            </div>
            <div class="list-group list-group-flush shadow-sm p-3 mb-5 bg-white">
                <div class="table-responsive">
                    <table class="table table-bordered border-light table-hover bg-white">
                        <colgroup>
                            <col width="5%">
                            <col width="25%">
                            <col width="15%">
                            <col width="15%">
                            <col width ="15%">
                            <col width="10%">
                            <col width="15%">
                        </colgroup>
                        <thead class="table-light">
                            <tr class="align-middle">
                                <th id="t1">@sortablelink('id', 'ID')</th>
                                <th id="t2">@sortablelink('user_name', 'Nome completo')</th>
                                <th id="t3">@sortablelink('cpf', 'CPF')</th>
                                <th id="t4">@sortablelink('user_email', 'E-mail')</th>
                                <th id="t5">@sortablelink('user_phone_number', 'Telefone')</th>
                                <th id="t6">@sortablelink('email', 'Papel')</th>
                                <th id="t7">Operações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                            <tr class="align-middle" style="height: 4rem">
                                <td headers="t1"><a href="{{ route('showUser', $user)}}">{{$user->id}}</td>
                                <td headers="t2"><a href="{{ route('showUser', $user)}}">{{$user->user_name}}</td>
                                <td headers="t3">{{$user->cpf}}</a></td>
                                <td headers="t4">{{$user->user_email}}</td>
                                <td headers="t5">{{$user->user_phone_number}}</td>
                                <td headers="t6">{{$user->getRoles->value('name')}}</td>
                                <td headers="t7">
                                    <div class="nav-item dropdown">
                                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                            Operações
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                            <a class="dropdown-item" href="{{ route('indexSubscribedEvents', $user)}}">
                                                Ver inscrições
                                            </a>

                                            <a class="dropdown-item" href="{{ route('showUser', $user)}}">
                                                Visualizar
                                            </a>

                                            <a class="dropdown-item" href="{{ route('editUser', $user)}}">
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
                                        <p>Deseja excluir o usuário <strong>{{$user->user_name}}</strong> ?</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                        <form action="{{ route('deleteEvent', $user->id)}}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">
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
