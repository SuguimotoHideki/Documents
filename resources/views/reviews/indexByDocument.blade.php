@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <h1 class='fs-2'>Avaliações</h1>
            <div class="list-group list-group-flush shadow-sm p-3 mb-5 bg-white">
                <div class="table-responsive">
                    <table class="table table-bordered border-light table-hover bg-white table-fixed">
                        <colgroup>
                            <col width ="25%">
                            <col width ="25%">
                            <col width ="25%">
                            <col width ="25%">
                        </colgroup>
                        <thead class="table-light">
                            <tr class="align-middle">
                                <th id="t1">Título</th>
                                <th id="t2">Pontuação</th>
                                <th id="t3">Recomendação</th>
                                <th id="t4">Anexo</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($reviews as $review)
                            @php
                                $status = $review->getStatusID()
                            @endphp
                            <tr class="align-middle" style="height:4rem">
                                <td headers="t1">{{$review->title}}</td>
                                <td headers="t2">{{$review->score}}</td>
                                <td headers="t3">
                                    @if($status === 0)
                                    <i class="fas fa-circle text-success"></i>
                                    @elseif($status === 1)
                                    <i class="fas fa-circle text-warning"></i>
                                    @elseif($status === 2)
                                    <i class="fas fa-circle text-danger"></i>
                                    @endif
                                    {{$review->getStatusValue()}}
                                </td>
                                <td headers="t4"><a href="/storage/{{$review->attachment}}">Ver anexo</a></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div> 
        </div>
    </div>
</div>
@endsection
