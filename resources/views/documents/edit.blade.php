@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <x-document-nav-menu :document="$document"/>
        <div class="col-md-9">
            <div class="card">
                <div class="card-header fw-bold fs-5">{{ __('Editar submissão') }}</div>
                <div class="card-body">
                        <form method="POST" action="/documents/{{$document->id}}/update" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row mb-4 justify-content-md-center">
                            <div class="col-md-10 py-1 text-center rounded-1 bg-warning">
                                <span>
                                    Atenção: caso esteja tendo problemas para submeter o documento, nos contate em <a href="">Placeholder</a>
                                </span>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="submission_type_id" class="col-md-2 col-form-label text-md-center text-break">
                                {{ __('Modalidade') }}
                                <span style="color: red">*</span>
                            </label>
                            <div class="col-md-9 my-auto">
                                <select name="submission_type_id" id="submission_type_id" class="col-md-12 my-auto" required>
                                    <option value="" disabled selected>Escolha uma opção</option>
                                    @foreach ($document->submission->event->submissionTypes as $type)
                                        <option value="{{$type->id}}" @selected($document->submission_type_id == $type->id)>{{ucfirst($type->name)}}</option>
                                    @endforeach
                                </select>
                            </div>
                            @error('submission_type_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="row mb-3">
                            <label for="title" class="col-md-2 col-form-label text-md-center">
                                {{ __('Título') }}
                                <span style="color: red">*</span>
                            </label>
                            <div class="col-md-9 my-auto">
                                <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ $document->title }}" placeholder="Título do documento" required autocomplete="title" autofocus>

                                @error('title')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="institution" class="col-md-2 col-form-label text-md-center">
                                {{ __('Instituição') }}
                                <span style="color: red">*</span>
                            </label>
                            <div class="col-md-9 my-auto">
                                <input id="institution" type="text" class="form-control @error('institution') is-invalid @enderror" name="institution" value="{{ $document->institution }}" placeholder="Instituição" required autocomplete="institution" autofocus>

                                @error('institution')
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
                                        <input type="text" class="form-control" value="{{ $document->submission->user->user_name }}" placeholder="Nome completo" required disabled autofocus>
                                    </div>
                                    <div class="col my-auto">
                                        <small class="form-text text-muted">Email</small>
                                        <input type="text" class="form-control" value="{{ $document->submission->user->user_email }}" placeholder="Email" required disabled autofocus>
                                    </div>
                                </div>
                                @for ($i = 0; $i < 7; $i++)
                                    @if($i < $document->coAuthors()->count())
                                        <div class="row mb-3">
                                            <div class="col my-auto">
                                                <input id="author_{{$i}}_name" type="text" class="form-control @error('author_' . $i . '_name') is-invalid @enderror author_{{$i}}_name" name="author_{{$i}}_name" value="{{ old('author_' . $i . '_name', $document->coAuthors[$i]->name) }}" placeholder="Nome completo" autocomplete="author_{{$i}}_name">
                                        
                                                @error('author_' . $i . '_name')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="col my-auto">
                                                <input id="author_{{$i}}_email" type="text" class="form-control @error('author_' . $i . '_email') is-invalid @enderror author_{{$i}}_email" name="author_{{$i}}_email" value="{{ old('author_' . $i . '_email', $document->coAuthors[$i]->email) }}" placeholder="Ex: email@exemplo.com" autocomplete="author_{{$i}}_email">
                                        
                                                @error('author_' . $i . '_email')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    @else
                                        <div class="row mb-3">
                                            <div class="col my-auto">
                                                <input id="author_{{$i}}_name" type="text" class="form-control @error('author_' . $i . '_name') is-invalid @enderror author_{{$i}}_name" name="author_{{$i}}_name" value="{{ old('author_' . $i . '_name') }}" placeholder="Nome completo" autocomplete="author_{{$i}}_name">
                                        
                                                @error('author_' . $i . '_name')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="col my-auto">
                                                <input id="author_{{$i}}_email" type="text" class="form-control @error('author_' . $i . '_email') is-invalid @enderror author_{{$i}}_email" name="author_{{$i}}_email" value="{{ old('author_' . $i . '_email') }}" placeholder="Ex: email@exemplo.com" autocomplete="author_{{$i}}_email">
                                        
                                                @error('author_' . $i . '_email')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    @endif
                                @endfor
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="keyword" class="col-md-2 col-form-label text-md-center">
                                {{ __('Palavras-chave') }}
                                <span style="color: red">*</span>
                            </label>
                            <div class="col-md-9 my-auto">
                                <input id="keyword" type="text" class="form-control @error('keyword') is-invalid @enderror" name="keyword" value="{{ $document->keyword }}" placeholder="Exemplo: Saúde, Meio-Ambiente, Doenças, etc" required autocomplete="keyword" autofocus>
                                <small class="form-text text-muted">Separe cada item por vírgula</small>
                                @error('keyword')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="attachment_author" class="col-md-2 col-form-label text-md-center">
                                {{ __('Trabalho com identificação') }}
                                <span style="color: red">*</span>
                            </label>
                            <div class="col-md-9 my-auto">
                                <div class="row">
                                    <div class="col-md-10 my-auto">
                                        <input id="attachment_author" type="file" class="form-control @error('attachment_author') is-invalid @enderror" name="attachment_author" value="{{ old('attachment_author') }}" accept="application/pdf">

                                        @error('attachment_author')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="col-md-2 my-auto text-md-end">
                                        <a href="/storage/{{$document->attachment_author}}" class="btn btn-primary">Ver anexo</a>
                                    </div>
                                </div>
                                <a href="#" class="col-md-2" data-bs-toggle="modal" data-bs-target="#attachmentHelpPrompt"><i class="fa-regular fa-circle-question"></i> Ajuda</a>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="attachment_no_author" class="col-md-2 col-form-label text-md-center">
                                {{ __('Trabalho sem identificação') }}
                                <span style="color: red">*</span>
                            </label>
                            <div class="col-md-9 my-auto">
                                <div class="row">
                                    <div class="col-md-10 my-auto">
                                        <input id="attachment_no_author" type="file" class="form-control @error('attachment_no_author') is-invalid @enderror" name="attachment_no_author" value="{{ old('attachment_no_author') }}" accept="application/pdf">

                                        @error('attachment_no_author')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="col-md-2 my-auto text-md-end">
                                        <a href="/storage/{{$document->attachment_no_author}}" class="btn btn-primary">Ver anexo</a>
                                    </div>
                                </div>
                                <a href="#" class="col-md-2" data-bs-toggle="modal" data-bs-target="#attachmentHelpPrompt"><i class="fa-regular fa-circle-question"></i> Ajuda</a>
                            </div>
                        </div>
                        <div class="modal fade" id="editPrompt" tabindex="-1" aria-labelledby="editPromptLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Salvar alterações</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p>Deseja confirmar as alterações na submissão ?</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                        <form action="{{ route('updateDocument', $document)}}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="btn btn-primary">
                                                {{ __('Salvar') }}
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="d-grid col-5 mx-auto">
                            <a href="{{ url()->previous() }}" class="btn btn-outline-dark">
                                Voltar
                            </a>
                        </div>
                        <div class="d-grid col-5 mx-auto">
                            <button type="submit" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#editPrompt">
                                {{ __('Salvar alterações') }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="attachmentHelpPrompt" tabindex="-1" aria-labelledby="attachmentHelpPromptLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content col-md-10">
            <div class="modal-header">
                <h5 class="modal-title">O que devo anexar ?</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h1 class="fw-bold fs-5">Trabalho sem identificação</h1>
                <p>
                    Para assegurar a imparcialidade no processo de avaliação, é crucial que este arquivo <strong>NÃO revele a identidade das pessoas envolvidas em seu desenvolvimento</strong>. A confidencialidade dos autores é essencial para garantir uma avaliação justa e objetiva. Se o trabalho contiver qualquer forma de identificação de seus autores, ele será automaticamente desqualificado.
                </p>
                <h1 class="fw-bold fs-5">Trabalho com identificação</h1>
                <p>
                    Neste caso, você deve anexar o mesmo trabalho com a identificação de todos os autores. Caso o trabalho seja aprovado, esta versão identificada será utilizada na publicação do evento após ser validada. Certifique-se de fornecer informações precisas e completas sobre os autores para a devida atribuição de créditos.
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Ok, entendido!</button>
            </div>
        </div>
    </div>
</div>
@endsection