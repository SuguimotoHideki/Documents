@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">{{ __('Publicar documento') }}</div>

                <div class="card-body">
                    <form method="POST" action="/documents" enctype="multipart/form-data">
                        @csrf
                        <div class="row mb-3">
                            <label for="author" class="col-md-3 col-form-label text-md-center">{{ __('Autor') }}</label>
                            <div class="col-md-8">
                                <input id="author" type="text" class="form-control @error('author') is-invalid @enderror" name="author" value="{{ old('author') }}" required autocomplete="author" autofocus>

                                @error('author')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="title" class="col-md-3 col-form-label text-md-center">{{ __('Título') }}</label>
                            <div class="col-md-8">
                                <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title') }}" required autocomplete="title" autofocus>

                                @error('title')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="advisor" class="col-md-3 col-form-label text-md-center">{{ __('Orientador') }}</label>
                            <div class="col-md-8">
                                <input id="advisor" type="text" class="form-control @error('advisor') is-invalid @enderror" name="advisor" value="{{ old('advisor') }}" required autocomplete="advisor" autofocus>

                                @error('advisor')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="abstract" class="col-md-3 col-form-label text-md-center">{{ __('Resumo') }}</label>
                            <div class="col-md-8">
                                <textarea id="abstract" type="text" class="form-control @error('abstract') is-invalid @enderror" rows="10" name="abstract" required autocomplete="abstract" autofocus>{{ old('abstract') }}</textarea>

                                @error('abstract')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="keyword" class="col-md-3 col-form-label text-md-center">{{ __('Palavras chave (Separado por vírgula)') }}</label>
                            <div class="col-md-8">
                                <input id="keyword" type="text" class="form-control @error('keyword') is-invalid @enderror" name="keyword" value="{{ old('keyword') }}" placeholder="Exemplo: Saúde, Meio-Ambiente, Doenças, etc" required autocomplete="keyword" autofocus>

                                @error('keyword')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="descriptor" class="col-md-3 col-form-label text-md-center">{{ __('Descritores (Separado por vírgula)') }}</label>
                            <div class="col-md-8">
                                <input id="descriptor" type="text" class="form-control @error('descriptor') is-invalid @enderror" name="descriptor" value="{{ old('descriptor') }}" placeholder="Exemplo: Saúde, Meio-Ambiente, Doenças, etc" required autocomplete="descriptor" autofocus>

                                @error('descriptor')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="document_type" class="col-md-3 col-form-label text-md-center">{{ __('Tipo de documento') }}</label>
                            <div class="col-md-8">
                                <input id="document_type" type="text" class="form-control @error('document_type') is-invalid @enderror" name="document_type" value="{{ old('document_type') }}" required autocomplete="document_type" autofocus>

                                @error('document_type')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="document" class="col-md-3 col-form-label text-md-center">{{ __('Arquivo') }}</label>
                            <div class="col-md-8">
                                <input id="document" type="file" class="form-control @error('document') is-invalid @enderror" name="document" value="{{ old('document') }}" required autocomplete="document" autofocus>

                                @error('document')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="justify-content-center text-center">
                                <button type="submit" class="btn btn-primary bg-blue-600">
                                    {{ __('Publicar') }}
                                </button>
                            <div class="btn">
                                <a href="/" class="text-black ml-4">Voltar</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
