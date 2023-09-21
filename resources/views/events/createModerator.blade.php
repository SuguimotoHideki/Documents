@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <x-event-nav-menu :event="$event"/>
        <div class="col-md-9">
            <div class="card">
                <div class="card-header fw-bold fs-5">{{ __('Moderadores') }}</div>
                <form method="POST" action="{{ route('storeModerator', $event)}}">
                    @csrf
                    <div class="list-group list-group-flush px-3 shadow-sm">
                        <div class="table-responsive">
                            <table class="table table-bordered border-light table-hover caption-top">
                                <caption><i class="fa-regular fa-circle-question"></i> Permitir edição do evento, ver inscrições e submissões, atribuir avaliadores para submissões.</caption>
                                <colgroup>
                                    <col width="50%">
                                    <col width="50%">
                                </colgroup>
                                <thead class="table-light">
                                    <tr class="align-middle">
                                        <th id="t1">@sortablelink('user_name', 'Usuário')</th>
                                        <th id="t2">Permissões</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($users as $user)
                                    <tr class="align-middle" style="height:4rem">
                                        <td headers="t1">{{$user->user_name}}</td>
                                        <td headers="t2">
                                            <div class="form-check form-check-inline">
                                                <input type="hidden" name="permissions[{{$user->id}}]" value=0>
                                                @if($event->isMod($user))
                                                    <input type="checkbox" class="form-check-input" id="{{$user->id}}_manage" name="permissions[{{$user->id}}]" value="1" checked>
                                                @else
                                                    <input type="checkbox" class="form-check-input" id="{{$user->id}}_manage" name="permissions[{{$user->id}}]" value="1">
                                                @endif
                                                <label for="{{$user->id}}_manage" class="form-check-label">{{'Moderador'}}</label>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div> 
                    <div class="card-footer">
                        <div class="row">
                            <div class="d-grid col-5 mx-auto">
                                <a href="{{ url()->previous()}}" class="btn btn-outline-dark">
                                    Voltar
                                </a>
                            </div>
                            <div class="d-grid col-5 mx-auto">
                                <button type="submit" class="btn btn-success">
                                    {{ __('Salvar alterações') }}
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
