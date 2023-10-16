@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="row mb-2">
                <h1 class='fs-2 col mb-2'>Notificações lidas</h1>
            </div>
            <div class="list-group list-group-flush shadow-sm p-3 bg-white">
                <div>
                    <nav class="mb-3 navbar navbar-expand navbar-light bg-white py-0 border-bottom">
                        <div class="navbar-nav me-auto">
                            <a href="{{route('indexUnread')}}" class="nav-item nav-link">Notificações novas</a>
                        </div>
                    </nav>
                </div>
                @foreach ($notifications as $notif)
                    <div class="row alert alert-warning mb-3 mx-3 rounded-2">
                        <div class="col-md-10 d-flex align-items-center">
                            <span>
                                [{{ date_format($notif->created_at, 'd/m/Y G:i:s') }}] A submissão <a href="{{route('showDocument', $notif->data['id'])}}">{{$notif->data['title']}}</a> requer um avaliador adicional para desempate.
                            </span>
                        </div>
                        <div class="col-md-2 d-flex align-items-center">
                            <div>
                                [<strong>Lida em </strong>{{date_format($notif->read_at, 'd/m/Y G:i:s')}}]
                            </div>
                        </div>
                    </div>                    
                @endforeach
            </div> 
        </div>
    </div>
</div>
@endsection
