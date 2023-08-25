@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <h1 class="fs-3 fw-bold text-uppercase text-center mb-3">Página não encontrada</h1>
        <div class="col-md-7">
            <div class="shadow-sm p-5 mb-5 bg-white">
                <h2 class="fs-5 fw-bold mb-2">Sentimos muito pelo inconveniente. A página que você busca não pode ser encontrada.</h2>
                <div>
                    <h3 class="fs-6 fw-bold">Possíveis razões:</h3>
                    <ul>
                        <li>O endereço pode ter sido digitado errado.</li>
                        <li>O link pode estar quebrado ou desatualizado.</li>
                    </ul>
                </div>
                <div class="row">
                    <div class="d-grid col-4 mx-auto">
                        <a href="{{ url()->previous() }}" class="btn btn-primary">
                            <i class="fa-solid fa-arrow-left"></i> Voltar
                        </a>
                    </div>
                    <div class="d-grid col-4 mx-auto">
                        <a href="" class="btn btn-outline-dark">
                            Contate a gente
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection