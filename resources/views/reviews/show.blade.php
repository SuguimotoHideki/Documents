@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        @role('user')
            <x-document-nav-menu :document="$document"/>
        @else
            <x-review-nav-menu :document="$document" :review="$review"/>
        @endif
        <div class="col-md-9">
            <div class="shadow-sm p-3 mb-3 bg-white">
                <div class="col-md">
                    <h1 class="fs-4 fw-bold text-uppercase mb-1">{{$review->title}}</h1>
                    <div class="text-muted">Avaliação nº: {{$review->id}}</div>
                </div>
                @if(!Auth::user()->hasRole('user'))
                    <div class="col-md mt-3">
                        <h2 class="fs-default fw-bold mb-1">Avaliador:</h2>
                        <div>{{$review->user->user_name}}</div>
                    </div>
                @endif
                <div class="col-md mt-3">
                    <h2 class="fs-default fw-bold mb-1">Pontuações:</h2>
                    <small class="form-text text-muted">Os seguintes critérios foram avaliados de 0 à 10. A pontuação final é a média dos critérios abaixo.</small>
                    <div class="table-responsive">
                        <table id="score" class="table table-bordered table-striped border table-hover bg-white table-fixed">
                            @php
                                $colWidths = [20, 5, 5, 5, 5, 5, 5, 5, 5, 5, 5, 5];
                            @endphp
                            <colgroup>
                                @foreach($colWidths as $width)
                                    <col width="{{ $width }}%">
                                @endforeach
                            </colgroup>
                            <thead class="table-light">
                                <tr class="align-middle">
                                    <th id="label"></th>
                                    @for ($header = 0; $header < 11; $header++)
                                        <th id="t{{$header}}">{{$header}}</th>
                                    @endfor
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($fields as $field)
                                    <tr class="align-middle" style="height:4rem">
                                        <td headers="label">{{$field->name}}</td>
                                        @for ($row = 0; $row < 11; $row++)
                                            <td headers="{{$row}}">
                                                <input type="radio" value="{{$row}}" disabled {{ $review->getScore($field) == "$row" ? 'checked' : '' }}>
                                            </td>
                                        @endfor
                                    </tr>
                                    @error('score.' . $field->id)
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-md text-break mt-3">
                    <h2 class="fs-default fw-bold mb-1 text-start">Comentário:</h2>
                    <div>{{$review->comment}}</div>
                </div>
                @if(!Auth::user()->hasRole('user'))
                    <div class="col-md text-break mt-3">
                        <h2 class="fs-default fw-bold mb-1 text-start">Comentário privado:</h2>
                        <div>{{$review->moderator_comment}}</div>
                    </div>
                @endif
                @if($review->attachment !== null)
                    <div class="col-md mt-3">
                        <h2 class="fs-default fw-bold mb-1">
                            <i class="fa-regular fa-file"></i> Visualizar anexo:</h2>
                        <div><a href="/storage/{{$review->attachment}}">Clique aqui para abrir o arquivo</a></div>
                    </div>
                @endif
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <div class="shadow-sm p-3 bg-white h-100">
                        <div class="col-md">
                            <h2 class="fs-default fw-bold mb-1">Pontuação:</h2>
                            <div>{{$review->score}}</div>
                        </div>
                        <div class="col-md mt-3">
                            <h2 class="fs-default fw-bold mb-1">Recomendação:</h2>
                            @php
                                $status = $review->getStatusID()
                            @endphp
                            @if($status === 0)
                                <div class="bg-success text-white py-1 px-2 rounded-2 text-center w-50">
                                    {{$review->getStatusValue()}}
                                </div>
                            @elseif($status === 1)
                                <div class="bg-warning py-1 px-2 rounded-2 text-center w-50">
                                    {{$review->getStatusValue()}}
                                </div>
                            @elseif($status === 2)
                                <div class="bg-danger text-white py-1 px-2 rounded-2 text-center w-50">
                                    {{$review->getStatusValue()}}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <div class="shadow-sm p-3 bg-white h-100">
                        <div class="col-md">
                            <h2 class="fs-default fw-bold mb-1">
                                <i class="fa-regular fa-clock"></i> Enviado em:</h2>
                            <div>{{$review->formatDate($review->created_at)}}</div>
                        </div>
                        <div class="col-md mt-3">
                            <h2 class="fs-default fw-bold mb-1">
                                <i class="fa-regular fa-clock"></i> Atualizado em:</h2>
                            <div>{{$review->formatDate($review->updated_at)}}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
