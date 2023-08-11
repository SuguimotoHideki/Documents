@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            @if (Auth::user()->id === $user->id)
                <h1 class='fs-2'>Minhas inscrições</h1>
            @else
                <h1 class='fs-2'>Inscrições de {{$user->user_name}}</h1>
            @endif
            @can('manage any event')
            <div class="list-group list-group-flush shadow-sm p-3 mb-5 bg-white">
                <div class="table-responsive">
                    <table class="table bg-white">
                        <colgroup>
                            <col width="5%">
                            <col width="20%">
                            <col width="15%">
                            <col width="15%">
                            <col width ="15%">
                            <col width="15%">
                            <col width="15%">
                        </colgroup>
                        <thead>
                            <tr class="align-middle">
                                <th id="t1">
                                    <a href="{{ route('indexSubscribedEvents', ['user' => $user, 'sort' => 'event_user.id', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc'])}}">ID da inscrição</a>
                                    @if(request('sort') === 'event_user.id')
                                        <i class="{{request('direction') === 'asc' ? 'fa fa-sort-asc' : 'fa fa-sort-desc'}}"></i>
                                    @else
                                        <i class="fa fa-sort"></i>
                                    @endif
                                </th>
                                <th id="t2">@sortablelink('event_name', 'Evento')</th>
                                <th id="t3">@sortablelink('event_email', 'Email do evento')</th>
                                <th id="t4">@sortablelink('status', 'Status')</th>
                                <th id="t5">@sortablelink('subscription_deadline', 'Prazo para submissão')</th>
                                <th id="t6">
                                    <a href="{{ route('indexSubscribedEvents', ['user' => $user, 'sort' => 'event_user.created_at', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc'])}}">Inscrito em</a>
                                    @if (request('sort') === 'event_user.created_at')
                                        <i class="{{request('direction') === 'asc' ? 'fa fa-sort-asc' : 'fa fa-sort-desc'}}"></i>
                                    @else
                                        <i class="fa fa-sort"></i>
                                    @endif
                                </th>
                                <th id="t7">Operações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($events as $event)
                            <tr class="align-middle">
                                <td headers="t1">{{$event->subscriptionData($user)['id']}}</td>
                                <td headers="t2"><a href="{{route('showEvent', $event)}}">{{$event->event_name}}</a></td>
                                <td headers="t3">{{$event->event_email}}</td>
                                <td headers="t4">{{$event->updateStatus($event->event_status)}}</td>
                                <td headers="t5">{{$event->formatDate($event->submission_start)}} - {{$event->formatDate($event->submission_deadline)}}</td>
                                <td headers="t6">{{$event->subscriptionData($user)['created_at']}}</td>
                                <td headers="t7">
                                    <div class="nav-item dropdown">
                                        <a href="#" class="nav-link dropdown-toggle" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                            Operações
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                            <button type="button" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#cancelSubscriptionPrompt{{$event->id}}">
                                                Cancelar inscrição
                                            </button>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <div class="modal fade" id="cancelSubscriptionPrompt{{$event->id}}" tabindex="-1" aria-labelledby="cancelSubscriptionPromptLabel" aria-hidden="true">
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
            </div> 
            @else
            <div class="list-group list-group-flush shadow-sm p-3 mb-5 bg-white">
                <div class="table-responsive">
                    <table class="table bg-white">
                        <colgroup>
                            <col width="20%">
                            <col width="20%">
                            <col width="15%">
                            <col width ="15%">
                            <col width ="15%">
                            <col width ="15%">
                        </colgroup>
                        <thead>
                            <tr class="align-middle">
                                <th id="t1">
                                    <a href="{{ route('indexSubscribedEvents', ['user' => $user, 'sort' => 'event_user.id', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc'])}}">ID da inscrição</a>
                                    @if(request('sort') === 'event_user.id')
                                        <i class="{{request('direction') === 'asc' ? 'fa fa-sort-asc' : 'fa fa-sort-desc'}}"></i>
                                    @else
                                        <i class="fa fa-sort"></i>
                                    @endif
                                </th>
                                <th id="t2">@sortablelink('event_name', 'Evento')</th>
                                <th id="t3">@sortablelink('event_email', 'Email do evento')</th>
                                <th id="t4">@sortablelink('status', 'Status')</th>
                                <th id="t5">@sortablelink('subscription_deadline', 'Prazo para submissão')</th>
                                <th id="t6">
                                    <a href="{{ route('indexSubscribedEvents', ['user' => $user, 'sort' => 'event_user.created_at', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc'])}}">Inscrito em</a>
                                    @if (request('sort') === 'event_user.created_at')
                                        <i class="{{request('direction') === 'asc' ? 'fa fa-sort-asc' : 'fa fa-sort-desc'}}"></i>
                                    @else
                                        <i class="fa fa-sort"></i>
                                    @endif
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($events as $event)
                            <tr class="align-middle">
                                <td headers="t1">{{$event->subscriptionData($user)['id']}}</td>
                                <td headers="t2"><a href="{{route('showEvent', $event)}}">{{$event->event_name}}</a></td>
                                <td headers="t3">{{$event->event_email}}</td>
                                <td headers="t4">{{$event->updateStatus($event->event_status)}}</td>
                                <td headers="t5">{{$event->formatDate($event->submission_start)}} - {{$event->formatDate($event->submission_deadline)}}</td>
                                <td headers="t6">{{$event->subscriptionData($user)['created_at']}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div> 
            @endcan
            
        </div>
    </div>
</div>
@endsection
