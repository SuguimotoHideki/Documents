@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <h1 class="fs-1 fw-bold text-uppercase text-center mb-3">{{'Proibido (403)'}}</h1>
        <div class="col-md-9">
            <div class="shadow-sm p-5 mb-5 bg-white align-middle">
                <h2 class="fs-3 fw-bold text-uppercase text-center mb-2">Sentimos muito...</h2>
                <div class="text-center">
                    <p class="mb-4">Você não tem as permissões necessárias para acessar essa página.</p>
                    <a href="{{ url()->previous()}}" class="btn btn-outline-dark"><i class="fa-solid fa-arrow-left"></i> Voltar</a>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection