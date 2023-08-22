@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="row mb-2">
                @if (Auth::user()->id === $user->id)
                    <h1 class='fs-2'>Minhas inscrições</h1>
                @else
                    <h1 class='fs-2'>Inscrições de {{$user->user_name}}</h1>
                @endif
            </div>
            @can('manage any event')
            <div class="list-group list-group-flush shadow-sm p-3 mb-5 bg-white">
                <div class="table-responsive">
                    <table class="table table-bordered border-light table-hover bg-white">
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
                                <th id="t2">@sortablelink('event_name', 'Evento')</th>
                                <th id="t3">Submissão</th>
                                <th id="t4">@sortablelink('event_user.created_at', 'Inscrito em')</th>
                                <th id="t5">Operações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($events as $event)
                            <tr class="align-middle" style="height: 4rem">
                                <td headers="t1">{{$event->subscriptionData($user)['id']}}</td>
                                <td headers="t2"><a href="{{route('showEvent', $event)}}">{{$event->event_name}}</a></td>
                                @if ($user->submission !== null)
                                    <td headers="t3"><a href="{{ route("showDocument", $user->submission->document)}}">{{$user->submission->document->title}}</a></td>
                                @else
                                    <td headers="t3">Submissão pendente</td>
                                @endif
                                <td headers="t4">{{$event->subscriptionData($user)['created_at']}}</td>
                                <td headers="t5">
                                    <div class="nav-item dropdown">
                                        <a href="#" class="nav-link dropdown-toggle" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                            Operações
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                            @if($user->submission !== null)
                                                <button type="button" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#cancelSubscriptionWarning{{$event->id}}">
                                                    Cancelar inscrição
                                                </button>
                                            @else
                                                <button type="button" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#cancelSubscriptionPrompt{{$event->id}}">
                                                    Cancelar inscrição
                                                </button>
                                            @endif
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
                            <div class="modal fade" id="cancelSubscriptionWarning{{$event->id}}" tabindex="-1" aria-labelledby="cancelSubscriptionWarningLabel" aria-hidden="true">
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
            @else
            <div class="list-group list-group-flush shadow-sm p-3 mb-5 bg-white">
                <div class="table-responsive">
                    <table class="table table-bordered border-light table-hover bg-white">
                        <colgroup>
                            <col width="10%">
                            <col width="15%">
                            <col width="15%">
                            <col width ="15%">
                            <col width ="15%">
                            <col width ="15%">
                            <col width ="15%">
                        </colgroup>
                        <thead class="table-light">
                            <tr class="align-middle">
                                <th id="t1">@sortablelink('event_user.id', 'Inscrição')</th>
                                <th id="t2">@sortablelink('event_name', 'Evento')</th>
                                <th id="t3">@sortablelink('event_email', 'Email do evento')</th>
                                <th id="t4">@sortablelink('event_status', 'Status')</th>
                                <th id="t5">@sortablelink('subscription_deadline', 'Prazo para submissão')</th>
                                <th id="t6">Submissão</th>
                                <th id="t7">@sortablelink('event_user.created_at', 'Inscrito em')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($events as $event)
                            <tr class="align-middle" style="height: 4rem">
                                <td headers="t1">{{$event->subscriptionData($user)['id']}}</td>
                                <td headers="t2"><a href="{{route('showEvent', $event)}}">{{$event->event_name}}</a></td>
                                <td headers="t3">{{$event->event_email}}</td>
                                <td headers="t4">{{$event->updateStatus()}}</td>
                                <td headers="t5">{{$event->formatDate($event->submission_start)}} - {{$event->formatDate($event->submission_deadline)}}</td>
                                <td headers="t6">
                                    @if($event->userSubmission($user) !== null)
                                        <a href="{{ route('showDocument', $event->submission->document)}}">{{$event->userSubmission($user)->id}}</a>
                                    @else
                                        <a href="{{ route('createDocument', $event)}}">Fazer submissão</a>
                                    @endif
                                </td>
                                <td headers="t7">{{$event->subscriptionData($user)['created_at']}}</td>
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
