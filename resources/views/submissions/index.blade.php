@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="row mb-2">
                @if (Auth::user()->id === $user->id)
                    <h1 class='fs-2 col'>Minhas submissões</h1>
                @else
                    <h1 class='fs-2'>Submissões de {{$user->user_name}}</h1>
                @endif
            </div>
            @if($submissions->count() === 0)
                <div class="text-center">
                    <div class="row mb-2">
                        @if (Auth::user()->id === $user->id)
                            <p>Ainda não há submissões. Inscreva-se em um evento para fazer uma submissão.</p>
                            <a href="/">
                                <button type="submit" class="btn btn-success bg-blue-600 mt-4">
                                    {{ __('Ver eventos') }}
                                </button>
                            </a>
                        @else
                            <p>Ainda não há submissões desse usuário.</p>
                        @endif
                </div>
            @else
            <div class="list-group list-group-flush shadow-sm p-3 mb-5 bg-white">
                <div class="table-responsive">
                    <table class="table table-bordered border-light table-hover bg-white table-fixed">
                            <colgroup>
                                <col width="12%">
                                <col width="12%">
                                <col width="30%">
                                <col width ="15%">
                                <col width ="20%">
                                <col width ="20%">
                            </colgroup>
                            <thead class="table-light">
                                <tr class="align-middle">
                                    <th id="t1">@sortablelink('document.id', 'Número')</th>
                                    <th id="t3">@sortablelink('document.type', 'Modalidade')</th>
                                    <th id="t2">@sortablelink('document.title', 'Título')</th>
                                    <th id="t4">@sortablelink('status', 'Status')</th>
                                    <th id="t5">Avaliações</th>
                                    <th id="t6">@sortablelink('event.event_name', 'Evento')</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($submissions as $submission)
                                @php
                                    $status = $submission->getStatusID()
                                @endphp
                                <tr class="align-middle" style="height:4rem">
                                    <td headers="t1"><a href="{{ route('showDocument', $submission->document)}}">{{$submission->id}}</a></td>
                                    <td headers="t2">{{$submission->document->type}}</td>
                                    <td headers="t3" class="text-truncate"><a href="{{ route('showDocument', $submission->document)}}">{{$submission->document->title}}</a></td>
                                    <td headers="t4">
                                        @if($status === 0)
                                        <i class="fas fa-circle text-success"></i>
                                        @elseif($status === 1)
                                        <i class="fas fa-circle text-danger"></i>
                                        @elseif($status === 2)
                                        <i class="fas fa-circle text-warning"></i>
                                        @else
                                        <i class="fas fa-circle text-primary"></i>
                                        @endif
                                        {{ $submission->getStatusValue()}}
                                    </td>
                                    <td headers="t5"><a href="{{ route('indexByDocument', $submission->document)}}">Ver avaliações</a></td>
                                    <td headers="t6"><a href="{{ route('showEvent', $submission->event)}}">{{$submission->event->event_name}}</a></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div> 
            @endif
        </div>
    </div>
</div>
@endsection
