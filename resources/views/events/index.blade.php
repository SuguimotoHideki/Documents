@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="row mb-2">
                <h1 class='fs-2'>Eventos em andamento</h1>
            </div>
            <div class="list-group list-group-flush shadow-sm p-3 bg-white">
                <form action="{{route('indexEvents')}}" method="GET">
                    <div class="row">
                        <div class="col-md-10 mb-3">
                            <input name="search" class="form-control" type="text" placeholder="Buscar pelo nome do evento ou organizador" aria-label="Search">
                        </div>
                        <div class="col-md-2 mb-3">
                            <button class="btn btn-primary w-100"><i class="fa-solid fa-magnifying-glass"></i> Buscar</button>
                        </div>
                    </div>
                </form>

                <div class="table-responsive mb-2">
                    <table class="table table-bordered border-light table-hover bg-white table-fixed">
                        <colgroup>
                            <col width="15%">
                            <col width="15%">
                            <col width="15%">
                            <col width ="15%">
                            <col width ="15%">
                            <col width ="15%">
                        </colgroup>
                        <thead class="table-light">
                            <tr class="align-middle">
                                <th id="t1">@sortablelink('name', 'Evento')</th>
                                <th id="t2">@sortablelink('email', 'Email')</th>
                                <th id="t3">@sortablelink('organizer', 'Organizador')</th>
                                <th id="t4">@sortablelink('status', 'Inscrições')</th>
                                <th id="t4">@sortablelink('status', 'Submissões')</th>
                                <th id="t5">@sortablelink('subscription_deadline', 'Inscrições')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($events as $event)
                            @php
                                $event->updateStatus();
                            @endphp
                            <tr class="align-middle" style="height:4rem">
                                <td headers="t1"><a href="{{route('showEvent', $event)}}">{{$event->name}}</a></td>
                                <td headers="t5" class="text-truncate">{{$event->email}}</td>
                                <td headers="t3">{{$event->organizer}}</td>
                                <td headers="t4">
                                    @if($event->getStatusID() == 0)
                                        <div class="bg-secondary text-white mx-3 py-1 rounded-2 text-center">
                                            Em breve
                                        </div>
                                    @elseif($event->getStatusID() == 1)
                                        <div class="bg-success text-white mx-3 py-1 rounded-2 text-center">
                                            Abertas
                                        </div>
                                    @else
                                        <div class="bg-danger text-white mx-3 py-1 rounded-2 text-center">
                                            Encerradas
                                        </div>
                                    @endif
                                </td>

                                <td headers="t5">
                                    @if($event->getStatusID() < 3)
                                        <div class="bg-secondary text-white mx-3 py-1 rounded-2 text-center">
                                            Em breve
                                        </div>
                                    @elseif($event->getStatusID() == 3)
                                        <div class="bg-success text-white mx-3 py-1 rounded-2 text-center">
                                            Abertas
                                        </div>
                                    @else
                                        <div class="bg-danger text-white mx-3 py-1 rounded-2 text-center">
                                            Encerradas
                                        </div>
                                    @endif
                                </td>
                                <td headers="t6">{{$event->getSubscriptionDates()}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div>
                    {{$events->links('pagination::bootstrap-4')}}
                </div>
            </div> 
        </div>
    </div>
</div>
@endsection
