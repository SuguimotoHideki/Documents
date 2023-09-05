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
                            <col width ="15%">
                            <col width ="15%">
                            <col width ="15%">
                            <col width ="15%">
                            <col width ="15%">
                            <col width ="15%">
                            <col width ="15%">
                        </colgroup>
                        <thead class="table-light">
                            <tr class="align-middle">
                                <th id="t1">Título</th>
                                <th id="t2">Avaliador</th>
                                <th id="t3">Submissão</th>
                                <th id="t4">Pontuação</th>
                                <th id="t5">Recomendação</th>
                                <th id="t6">Avaliado em</th>
                                <th id="t7">Atualizado em</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($reviews as $review)
                            @php
                                $status = $review->getStatusID()
                            @endphp
                            <tr class="align-middle" style="height:4rem">
                                <td headers="t1"><a href="{{route('showReview', [$review, $review->document])}}">{{$review->title}}</a></td>
                                <td headers="t2">{{$review->user->user_name}}</td>
                                <td headers="t3" class="text-truncate"><a href="{{ route('showDocument', $review->document)}}">{{$review->document->title}}</a></td>
                                <td headers="t4">{{$review->score}}</td>
                                <td headers="t5">
                                    @if($status === 0)
                                    <i class="fas fa-circle text-success"></i>
                                    @elseif($status === 1)
                                    <i class="fas fa-circle text-warning"></i>
                                    @elseif($status === 2)
                                    <i class="fas fa-circle text-danger"></i>
                                    @endif
                                    {{$review->getStatusValue()}}
                                </td>
                                <td headers="t7">{{$review->formatDate($review->created_at)}}</td>
                                <td headers="t8">{{$review->formatDate($review->updated_at)}}</td>
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
