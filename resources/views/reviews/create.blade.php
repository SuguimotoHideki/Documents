@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header fw-bold fs-5">{{ __("Avaliação de $document->title") }}</div>
                <div class="shadow-sm p-3 mb-3 bg-white">
                    <h2 class="fs-5 fw-bold mt-3">
                        <i class="fa-regular fa-file"></i> Visualizar submissão:</h2>
                    <div class="mt-2"><a href="/storage/{{$document->document}}">Clique aqui para abrir o arquivo da submissão.</a></div>
                </div>
                <form method="POST" action="{{ route('storeReview', $document)}}" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="row mb-3">
                            <label for="title" class="col-md-2 col-form-label text-md-center">
                                {{ __('Título') }}
                                <span style="color: red">*</span>
                            </label>
                            <div class="col-md-9 my-auto">
                                <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title') }}" placeholder="Título da avaliação" required autocomplete="title" autofocus>
                                <small class="form-text text-muted">Insira uma breve descrição da avaliação.</small>
                                @error('title')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="score" class="col-md-2 col-form-label text-md-center">
                                {{ __('Pontuação') }}
                                <span style="color: red">*</span>
                            </label>
                            <div class="col-md-9 my-auto">
                                <input id="score" type="number" step="0.01" min="0" max="10" class="form-control @error('score') is-invalid @enderror" name="score" value="{{ old('score') }}" placeholder="Pontuação da submissão" required autocomplete="score" autofocus>
                                <small class="form-text text-muted">Valor entre 0 e 10. Se for decimal, separe por '.'</small>
                                @error('score')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="comment" class="col-md-2 col-form-label text-md-center">
                                {{ __('Comentário') }}
                                <span style="color: red">*</span>
                            </label>
                            <div class="col-md-9 my-auto">
                                <textarea id="comment" type="text" class="form-control @error('comment') is-invalid @enderror" rows="10" name="comment" required autocomplete="comment" placeholder="Digite nesse espaço a sua avaliação da submissão. O conteúdo será exibido para o autor da submissão." autofocus>{{ old('comment') }}</textarea>
                                @error('comment')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="moderator_comment" class="col-md-2 col-form-label text-md-center">
                                {{ __('(Opcional) Comentário confidencial') }}
                            </label>
                            <div class="col-md-9 my-auto">
                                <textarea id="moderator_comment" type="text" class="form-control @error('moderator_comment') is-invalid @enderror" rows="10" name="moderator_comment" autocomplete="moderator_comment" placeholder="O conteúdo desse campo será exibido apenas para moderadores e administradores." autofocus>{{ old('moderator_comment') }}</textarea>
                                @error('moderator_comment')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="recommendation" class="col-md-2 col-form-label text-md-center text-break">
                                {{ __('Recomendação') }}
                                <span style="color: red">*</span>
                            </label>
                            <div class="col-md-9 my-auto">
                                <select name="recommendation" id="recommendation" class="col-md-12 my-auto" required>
                                    <option value="" disabled selected>Escolha uma opção</option>
                                    <option value="0" {{old ('recommendation') == '0' ? 'selected' : ''}} class="text-success">Aprovado</option>
                                    <option value="1" {{old ('recommendation') == '1' ? 'selected' : ''}}>Revisão</option>
                                    <option value="2" {{old ('recommendation') == '2' ? 'selected' : ''}} class="text-danger">Reprovado</option>
                                </select>
                            </div>
                            @error('recommendation')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="row mb-3">
                            <label for="attachment" class="col-md-2 col-form-label text-md-center">
                                {{ __('(Opcional) Anexo') }}
                            </label>
                            <div class="col-md-9 my-auto">
                                <input id="attachment" type="file" class="form-control @error('attachment') is-invalid @enderror" name="attachment" value="{{ old('attachment') }}" autocomplete="attachment" autofocus>
                                <small class="form-text text-muted">Envie um anexo contendo sugestões de correção.</small>
                                @error('attachment')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <input type="text" name="user_id" value="{{Auth::user()->id}}" hidden>
                        <input type="text" name="document_id" value="{{$document->id}}" hidden>
                    </div>
                    <div class="modal fade" id="createPrompt" tabindex="-1" aria-labelledby="createPromptLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Salvar avaliação</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <p>Deseja enviar a avaliação da submissão <strong>{{$document->title}}</strong> ?</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Voltar</button>
                                    <form method="POST" action="{{ route('storeReview', $document)}}" enctype="multipart/form-data">
                                        @csrf
                                        <button type="submit" class="btn btn-primary">
                                            {{ __('Enviar') }}
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="card-footer">
                    <div class="row">
                        <div class="d-grid col-5 mx-auto">
                            <a href="{{ url()->previous() }}" class="btn btn-outline-dark">
                                Voltar
                            </a>
                        </div>
                        <div class="d-grid col-5 mx-auto">
                            <button type="submit" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#createPrompt">
                                {{ __('Enviar avaliação') }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection