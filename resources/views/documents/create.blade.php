@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">{{ __('Submeter documento') }}</div>
                <form method="POST" action="/documents" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="row mb-5 justify-content-md-center">
                            <div class="col-md-10 py-1 text-center rounded-1 bg-warning">
                                <span>
                                    Atenção: caso esteja tendo problemas para submeter o documento, nos contate em <a href="">Placeholder</a>
                                </span>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="title" class="col-md-2 col-form-label text-md-center">
                                {{ __('Título') }}
                                <span style="color: red">*</span>
                            </label>
                            <div class="col-md-9 my-auto">
                                <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title') }}" placeholder="Título do documento" required autocomplete="title" autofocus>

                                @error('title')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="document_institution" class="col-md-2 col-form-label text-md-center">
                                {{ __('Instituição') }}
                                <span style="color: red">*</span>
                            </label>
                            <div class="col-md-9 my-auto">
                                <input id="document_institution" type="text" class="form-control @error('document_institution') is-invalid @enderror" name="document_institution" value="{{ old('document_institution') }}" placeholder="Instituição" required autocomplete="document_institution" autofocus>

                                @error('document_institution')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="abstract" class="col-md-2 col-form-label text-md-center">
                                {{ __('Resumo') }}
                                <span style="color: red">*</span>
                            </label>
                            <div class="col-md-9 my-auto">
                                <textarea id="abstract" type="text" class="form-control @error('abstract') is-invalid @enderror" rows="10" name="abstract" required autocomplete="abstract" autofocus>{{ old('abstract') }}</textarea>

                                @error('abstract')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="author" class="col-md-2 col-form-label text-md-center my-auto">
                                {{ __('Autor(es)') }}
                                <span style="color: red">*</span>
                            </label>
                            <div class="col-md-9 my-auto">
                                <div class="row mb-3">
                                    <div class="col my-auto">
                                        <small class="form-text text-muted">Nome completo</small>
                                        <input type="text" class="form-control" value="{{ Auth()->getUser()->user_name }}" placeholder="Nome completo" required disabled autofocus>
                                    </div>
                                    <div class="col my-auto">
                                        <small class="form-text text-muted">Email</small>
                                        <input type="text" class="form-control" value="{{ Auth()->getUser()->user_email }}" placeholder="Email" required disabled autofocus>
                                    </div>
                                </div>
                                @for ($i = 0; $i < 7; $i++)
                                    <div class="row mb-3">
                                        <div class="col my-auto">
                                            <input id="author_{{$i}}_name" type="text" class="form-control @error('author_' . $i . '_name') is-invalid @enderror author_{{$i}}_name" name="author_{{$i}}_name" value="{{ old('author_' . $i . '_name') }}" placeholder="Nome completo" autocomplete="author_{{$i}}_name">
                                    
                                            @error('author_{{$i}}_name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="col my-auto">
                                            <input id="author_{{$i}}_email" type="text" class="form-control @error('author_' . $i . '_email') is-invalid @enderror author_{{$i}}_email" name="author_{{$i}}_email" value="{{ old('author_' . $i . '_email') }}" placeholder="Ex: email@exemplo.com" autocomplete="author_{{$i}}_email">
                                    
                                            @error('author_{{$i}}_email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                @endfor
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="keyword" class="col-md-2 col-form-label text-md-center">
                                {{ __('Palavras-chave') }}
                                <span style="color: red">*</span>
                            </label>
                            <div class="col-md-9 my-auto">
                                <input id="keyword" type="text" class="form-control @error('keyword') is-invalid @enderror" name="keyword" value="{{ old('keyword') }}" placeholder="Exemplo: Saúde, Meio-Ambiente, Doenças, etc" required autocomplete="keyword" autofocus>
                                <small class="form-text text-muted">Separe cada item por vírgula</small>
                                @error('keyword')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                        </div>
                        <div class="row mb-3">
                            <label for="document_type" class="col-md-2 col-form-label text-md-center text-break">
                                {{ __('Tipo de documento') }}
                                <span style="color: red">*</span>
                            </label>
                            <div class="col-md-9 my-auto">
                                <select name="document_type" id="document_type" class="col-md-12 my-auto" required>
                                    <option value="" disabled selected>Escolha uma opção</option>
                                    <option value="Artigo" {{old ('document_type') == 'Artigo' ? 'selected' : ''}}>Artigo</option>
                                    <option value="Resumo" {{old ('document_type') == 'Resumo' ? 'selected' : ''}}>Resumo</option>
                                    <option value="TCC" {{old ('document_type') == 'TCC' ? 'selected' : ''}}>TCC</option>
                                </select>
                            </div>
                            @error('document_type')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="row mb-3">
                            <label for="document" class="col-md-2 col-form-label text-md-center">
                                {{ __('Arquivo PDF') }}
                                <span style="color: red">*</span>
                            </label>
                            <div class="col-md-9 my-auto">
                                <input id="document" type="file" class="form-control @error('document') is-invalid @enderror" name="document" value="{{ old('document') }}" required autocomplete="document" autofocus>

                                @error('document')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="d-grid col-5 mx-auto">
                                <button type="submit" class="btn btn-success">
                                    {{ __('Submeter documento') }}
                                </button>
                            </div>
                            <div class="d-grid col-5 mx-auto">
                                <a href="{{ url()->previous() }}" class="btn btn-outline-dark">
                                    Voltar
                                </a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection