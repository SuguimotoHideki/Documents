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
                            <div class="col-md-9 my-auto" id="author-field-container">
                                <div class="row mb-3">
                                    <div class="col">
                                        <small class="form-text text-muted">Nome completo</small>
                                        <input type="text" class="form-control" value="{{ Auth()->getUser()->user_name }}" placeholder="Nome completo" required disabled autofocus>
                                    </div>
                                    <div class="col">
                                        <small class="form-text text-muted">Email</small>
                                        <input type="text" class="form-control" value="{{ Auth()->getUser()->user_email }}" placeholder="Email" required disabled autofocus>
                                    </div>
                                </div>
                                <div class="row mb-3 author-fields">
                                    <div class="col my-auto">
                                        <input id="author_name" type="text" class="form-control @error('author_name') is-invalid @enderror author-name" name="author_name" value="{{ old('author_name') }}" placeholder="Nome completo" required autocomplete="author_name" autofocus>
                        
                                        @error('author_name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="col my-auto">
                                        <input id="author_email" type="text" class="form-control @error('author_email') is-invalid @enderror author-email" name="author_email" value="{{ old('author_email') }}" placeholder="Ex: email@exemplo.com" required autocomplete="author_email" autofocus>
                        
                                        @error('author_email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-9">
                                    <button id="add-author" type="button" class="btn btn-outline-dark">
                                        {{ __('Adicionar autor') }}
                                    </button>
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
                                <input id="document_type" type="text" class="form-control @error('document_type') is-invalid @enderror" name="document_type" value="{{ old('document_type') }}" required autocomplete="document_type" autofocus>

                                @error('document_type')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
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
@section('page-script')
    <script type="text/javascript">
        document.getElementById("add-author").addEventListener("click", addAuthorFields);
        
        function addAuthorFields() {
            var authorFieldContainer = document.getElementById("author-field-container");
            var newAuthorFields = authorFieldContainer.querySelector('.author-fields').cloneNode(true);
            var clonedAuthorNameField = newAuthorFields.querySelector(".author-name");
            var clonedAuthorEmailField = newAuthorFields.querySelector(".author-email");
            clonedAuthorNameField.value = "";
            clonedAuthorEmailField.value = "";
        
            // Append the cloned fields to the container
            authorFieldContainer.appendChild(newAuthorFields);
        }
    </script>
@endsection