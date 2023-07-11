@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">{{ __('Publicar documento') }}</div>
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
                                <div class="row mb-3">
                                    <div class="col my-auto">
                                        <input id="author_2_name" type="text" class="form-control @error('author_2_name') is-invalid @enderror author_2_name" name="author_2_name" value="{{ old('author_2_name') }}" placeholder="Nome completo" autocomplete="author_2_name">
                                
                                        @error('author_2_name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="col my-auto">
                                        <input id="author_2_email" type="text" class="form-control @error('author_2_email') is-invalid @enderror author_2_email" name="author_2_email" value="{{ old('author_2_email') }}" placeholder="Ex: email@exemplo.com" autocomplete="author_2_email">
                                
                                        @error('author_2_email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col my-auto">
                                        <input id="author_3_name" type="text" class="form-control @error('author_3_name') is-invalid @enderror author_3_name" name="author_3_name" value="{{ old('author_3_name') }}" placeholder="Nome completo" autocomplete="author_3_name">
                                
                                        @error('author_3_name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="col my-auto">
                                        <input id="author_3_email" type="text" class="form-control @error('author_3_email') is-invalid @enderror author_3_email" name="author_3_email" value="{{ old('author_3_email') }}" placeholder="Ex: email@exemplo.com" autocomplete="author_3_email">
                                
                                        @error('author_3_email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col my-auto">
                                        <input id="author_4_name" type="text" class="form-control @error('author_4_name') is-invalid @enderror author_4_name" name="author_4_name" value="{{ old('author_4_name') }}" placeholder="Nome completo" autocomplete="author_4_name">
                                
                                        @error('author_4_name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="col my-auto">
                                        <input id="author_4_email" type="text" class="form-control @error('author_4_email') is-invalid @enderror author_4_email" name="author_4_email" value="{{ old('author_4_email') }}" placeholder="Ex: email@exemplo.com" autocomplete="author_4_email">
                                
                                        @error('author_4_email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col my-auto">
                                        <input id="author_5_name" type="text" class="form-control @error('author_5_name') is-invalid @enderror author_5_name" name="author_5_name" value="{{ old('author_5_name') }}" placeholder="Nome completo" autocomplete="author_5_name">
                                
                                        @error('author_5_name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="col my-auto">
                                        <input id="author_5_email" type="text" class="form-control @error('author_5_email') is-invalid @enderror author_5_email" name="author_5_email" value="{{ old('author_5_email') }}" placeholder="Ex: email@exemplo.com" autocomplete="author_5_email">
                                
                                        @error('author_5_email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col my-auto">
                                        <input id="author_6_name" type="text" class="form-control @error('author_6_name') is-invalid @enderror author_6_name" name="author_6_name" value="{{ old('author_6_name') }}" placeholder="Nome completo" autocomplete="author_6_name">
                                
                                        @error('author_6_name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="col my-auto">
                                        <input id="author_6_email" type="text" class="form-control @error('author_6_email') is-invalid @enderror author_6_email" name="author_6_email" value="{{ old('author_6_email') }}" placeholder="Ex: email@exemplo.com" autocomplete="author_6_email">
                                
                                        @error('author_6_email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col my-auto">
                                        <input id="author_7_name" type="text" class="form-control @error('author_7_name') is-invalid @enderror author_7_name" name="author_7_name" value="{{ old('author_7_name') }}" placeholder="Nome completo" autocomplete="author_7_name">
                                
                                        @error('author_7_name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="col my-auto">
                                        <input id="author_7_email" type="text" class="form-control @error('author_7_email') is-invalid @enderror author_7_email" name="author_7_email" value="{{ old('author_7_email') }}" placeholder="Ex: email@exemplo.com" autocomplete="author_7_email">
                                
                                        @error('author_7_email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col my-auto">
                                        <input id="author_8_name" type="text" class="form-control @error('author_8_name') is-invalid @enderror author_8_name" name="author_8_name" value="{{ old('author_8_name') }}" placeholder="Nome completo" autocomplete="author_8_name">
                                
                                        @error('author_8_name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="col my-auto">
                                        <input id="author_8_email" type="text" class="form-control @error('author_8_email') is-invalid @enderror author_8_email" name="author_8_email" value="{{ old('author_8_email') }}" placeholder="Ex: email@exemplo.com" autocomplete="author_8_email">
                                
                                        @error('author_8_email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
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
                            <label for="document_type" class="col-md-2 col-form-label text-md-center">
                                {{ __('Tipo de documento') }}
                                <span style="color: red">*</span>
                            </label>
                            <div class="col-md-9 my-auto">
                                <select name="document_type" id="document_type" class="col-md-12 my-auto" required>
                                    <option value="" disbled selected>Escolha uma opção</option>
                                    <option value="Artigo">Artigo</option>
                                    <option value="Resumo">Resumo</option>
                                    <option value="TCC">TCC</option>
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