@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="row">
                <div class="col-md-8">
                    <h1 class="fs-2">Inscritos em {{$event->event_name}}</h1>
                </div>
                <div class="col-md-4 text-end">
                    <a href="{{route('manageEvents')}}" class="btn btn-outline-dark"><i class="fa-solid fa-arrow-left"></i> Eventos</a>
                </div>
            </div>
            <div class="list-group list-group-flush shadow-sm p-3 mb-5 bg-white">
                <div class="table-responsive">
                    <table class="table bg-white">
                        <colgroup>
                            <col width="20%">
                            <col width="20%">
                            <col width="20%">
                            <col width="20%">
                            <col width="20%">
                        </colgroup>
                        <thead>
                            <tr class="align-middle">
                                <th id="t1">
                                    <a href="{{ route('indexSubscribers', [$event, 'sort' => 'event_user.id', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc'])}}">ID da inscrição</a>
                                    @if(request('sort') === 'event_user.id')
                                        <i class="{{request('direction') === 'asc' ? 'fa fa-sort-asc' : 'fa fa-sort-desc'}}"></i>
                                    @else
                                        <i class="fa fa-sort"></i>
                                    @endif
                                </th>
                                <th id="t2">@sortablelink('user_name', 'Usuário')</th>
                                <th id="t3">Submissão</th>
                                <th id="t4">
                                    <a href="{{ route('indexSubscribers', [$event, 'sort' => 'event_user.created_at', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc'])}}">Inscrição em</a>
                                    @if(request('sort') === 'event_user.created_at')
                                        <i class="{{request('direction') === 'asc' ? 'fa fa-sort-asc' : 'fa fa-sort-desc'}}"></i>
                                    @else
                                        <i class="fa fa-sort"></i>
                                    @endif
                                </th>
                                <th id="t1">Operações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                            <tr class="align-middle" style="height: 4rem">
                                <td headers="t1">{{$event->subscriptionData($user)['id']}}</td>
                                <td headers="t2"><a href="{{ route('showUser', ['user' => $user])}}">{{$user->user_name}}</a></td>
                                <td headers="t3">TODO</td>
                                <td headers="t4">{{$event->subscriptionData($user)['created_at']}}</td>
                                <td headers="t5">
                                    <div class="nav-item dropdown">
                                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                            Operações
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                            <button type="button" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#cancelSubscriptionPrompt{{$user->id}}">
                                                Cancelar inscrição
                                            </button>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <div class="modal fade" id="cancelSubscriptionPrompt{{$user->id}}" tabindex="-1" aria-labelledby="cancelSubscriptionPromptLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Cancelar inscrição</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p>Deseja cancelar a inscrição de {{$user->user_name}} no evento {{$event->event_name}} ?</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                        <form action="{{ route('cancelSubscription', ['event' => $event, 'user' => $user])}}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-danger">
                                                {{ __('Confirmar') }}
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
                @if ($event->subscriptionCount() > 0)
                    <p class="fs-5 fw-semibold">Total de inscritos: {{$event->subscriptionCount()}}</p>                
                @endif
            </div>
        </div>
    </div>
</div>

@endsection