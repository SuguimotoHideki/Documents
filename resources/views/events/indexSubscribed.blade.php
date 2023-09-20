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
            @if($user->events()->count() === 0)
                <div class="text-center">
                    <div class="row mb-2">
                        @if (Auth::user()->id === $user->id)
                            <p>Ainda não há inscrições realizadas.</p>
                            <a href="/">
                                <button type="submit" class="btn btn-success bg-blue-600 mt-4">
                                    {{ __('Ver eventos') }}
                                </button>
                            </a>
                        @else
                            <p>Ainda não há inscrições desse usuário.</p>
                        @endif
                </div>
            @else
                @can('events.manage')
                <div class="list-group list-group-flush shadow-sm p-3 mb-5 bg-white">
                    <div class="table-responsive">
                        <table class="table table-bordered border-light table-hover bg-white table-fixed">
                            <colgroup>
                                <col width="20%">
                                <col width="20%">
                                <col width="20%">
                                <col width="20%">
                                <col width="20%">
                            </colgroup>
                            <thead class="table-light">
                                <tr class="align-middle">
                                    <th id="t1">@sortablelink('event_user.id', 'Inscrição')</th>
                                    <th id="t2">@sortablelink('name', 'Evento')</th>
                                    <th id="t3">Submissão</th>
                                    <th id="t4">@sortablelink('event_user.created_at', 'Inscrito em')</th>
                                    <th id="t5">Operações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($events as $event)
                                <tr class="align-middle" style="height: 4rem">
                                    <td headers="t1">{{$event->pivot->id}}</td>
                                    <td headers="t2"><a href="{{route('showEvent', $event)}}">{{$event->name}}</a></td>
                                    <td headers="t3" class="text-center">
                                        @if ($event->userSubmission($user) !== null)
                                            <a href="{{ route('showDocument', $event->userSubmission($user)->document)}}" class="btn btn-success mx-3 py-1 rounded-2">Ver submissão</a></td>
                                        @else
                                            <div class="btn btn-secondary mx-3 py-1 rounded-2 disabled">Pendente</div>
                                        @endif
                                    </td>
                                    <td headers="t4">{{$event->formatDateTime($event->pivot->created_at)}}</td>
                                    <td headers="t5">
                                        <div class="nav-item dropdown">
                                            <a href="#" class="nav-link dropdown-toggle" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                                Operações
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                                @if($user->submission !== null)
                                                    <button type="button" class="dropdown-item btn rounded-0" data-bs-toggle="modal" data-bs-target="#cancelSubscriptionWarning{{$event->id}}">
                                                        Cancelar inscrição
                                                    </button>
                                                @else
                                                    <button type="button" class="dropdown-item btn rounded-0" data-bs-toggle="modal" data-bs-target="#cancelSubscriptionPrompt{{$event->id}}">
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
                                            <p>Deseja cancelar a inscrição de <strong>{{$user->user_name}}</strong> no evento <strong>{{$event->name}}</strong> ?</p>
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
                                            <p><strong>{{$user->user_name}}</strong> possui uma submissão no evento <strong>{{$event->name}}</strong>, remova-a antes de cancelar a inscrição</p>
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
                        <table class="table table-bordered border-light table-hover bg-white table-fixed">
                            <colgroup>
                                <col width="8%">
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
                                    <th id="t2">@sortablelink('name', 'Evento')</th>
                                    <th id="t3">@sortablelink('email', 'Email')</th>
                                    <th id="t4">@sortablelink('status', 'Submissões')</th>
                                    <th id="t5">@sortablelink('subscription_deadline', 'Prazo para submissão')</th>
                                    <th id="t6">Submissão</th>
                                    <th id="t7">@sortablelink('event_user.created_at', 'Inscrito em')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($events as $event)
                                @php
                                    $event->updateStatus()
                                @endphp
                                <tr class="align-middle" style="height: 4rem">
                                    <td headers="t1">{{$event->pivot->id}}</td>
                                    <td headers="t2"><a href="{{route('showEvent', $event)}}">{{$event->name}}</a></td>
                                    <td headers="t3" class="text-truncate">{{$event->email}}</td>
                                    <td headers="t4">
                                        @if($event->getStatusID() < 3)
                                            <div class="bg-secondary text-white mx-3 py-1 rounded-2 text-md-center">
                                                Em breve
                                            </div>
                                        @elseif($event->getStatusID() === 3)
                                            <div class="bg-success text-white mx-3 py-1 rounded-2 text-md-center">
                                                Abertas
                                            </div>
                                        @else
                                            <div class="bg-danger text-white mx-3 py-1 rounded-2 text-md-center">
                                                Encerradas
                                            </div>
                                        @endif
                                    </td>
                                    <td headers="t5">{{$event->getSubmissionDates()}}</td>
                                    <td headers="t6" class="text-center">
                                        @if ($event->userSubmission($user) !== null)
                                            <a href="{{ route('showDocument', $event->userSubmission($user)->document)}}" class="btn btn-primary mx-3 py-1 rounded-2">Ver submissão</a></td>
                                        @else
                                            <div class="btn btn-secondary mx-3 py-1 rounded-2 disabled">Pendente</div>
                                        @endif
                                    </td>
                                    <td headers="t7">{{$event->formatDateTime($event->pivot->created_at)}}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div> 
                @endcan
            @endcan
        </div>
    </div>
</div>
@endsection
