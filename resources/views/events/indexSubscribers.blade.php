@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="row mb-2">
                <div class="col-md-8">
                    <h1 class="fs-2">Inscritos em {{$event->event_name}}</h1>
                </div>
                <div class="col-md-4 text-end">
                    <a href="{{route('manageEvents')}}" class="btn btn-outline-dark"><i class="fa-solid fa-arrow-left"></i> Eventos</a>
                </div>
            </div>
            <div class="list-group list-group-flush shadow-sm p-3 mb-5 bg-white">
                <nav class="mb-3 navbar navbar-expand navbar-light bg-white py-0 border-bottom">
                    <div class="navbar-nav me-auto">
                        <a href="{{route('indexEventSubmissions', $event->id)}}" class="nav-item nav-link">Ver submissões</a>
                        <a href="{{ route('showEvent', $event->id)}}" class="nav-item nav-link">Ver evento</a>
                    </div>
                </nav>
                <div class="table-responsive">
                    <table class="table table-bordered border-light table-hover bg-white caption-top">
                        <caption>N⁰ inscritos: {{$event->subscriptionCount()}}</caption>
                        <colgroup>
                            <col width="10%">
                            <col width="25%">
                            <col width="25%">
                            <col width="20%">
                            <col width="10%">
                        </colgroup>
                        <thead class="table-light">
                            <tr class="align-middle">
                                <th id="t1">@sortablelink('event_user.id', 'Inscrição')</th>
                                <th id="t2">@sortablelink('user_name', 'Usuário')</th>
                                <th id="t3">Submissão</th>
                                <th id="t4">@sortablelink('event_user.created_at', 'Inscrito em')</th>
                                <th id="t5">Operações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                            <tr class="align-middle" style="height: 4rem">
                                <td headers="t1">{{$event->subscriptionData($user)['id']}}</td>
                                <td headers="t2"><a href="{{ route('showUser', ['user' => $user])}}">{{$user->user_name}}</a></td>
                                @if ($event->submission !== null)
                                    <td headers="t3"><a href="{{ route("showDocument", $event->submission->document)}}">{{$event->submission->document->title}}</a></td>
                                @else
                                    <td headers="t4">Submissão pendente</td>
                                @endif
                                <td headers="t4">{{$event->subscriptionData($user)['created_at']}}</td>
                                <td headers="t5">
                                    <div class="nav-item dropdown">
                                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                            Operações
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                            @if($user->submission !== null)
                                                <button type="button" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#cancelSubscriptionWarning{{$user->id}}">
                                                    Cancelar inscrição
                                                </button>
                                            @else
                                                <button type="button" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#cancelSubscriptionPrompt{{$user->id}}">
                                                    Cancelar inscrição
                                                </button>
                                            @endif
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
                                        <p>Deseja cancelar a inscrição de <strong>{{$user->user_name}}</strong> no evento <strong>{{$event->event_name}}</strong> ?</p>
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
                            <div class="modal fade" id="cancelSubscriptionWarning{{$user->id}}" tabindex="-1" aria-labelledby="cancelSubscriptionWarningLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Cancelar inscrição</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p><strong>{{$user->user_name}}</strong> possui uma submissão no evento <strong>{{$event->event_name}}</strong>, remova-a antes de cancelar a inscrição</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">OK</button>
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