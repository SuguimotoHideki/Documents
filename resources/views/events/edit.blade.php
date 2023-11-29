@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <x-event-nav-menu :event="$event"/>
        <div class="col-md-9">
            <div class="card">
                <div class="card-header fw-bold fs-5">{{ __('Editar evento') }}</div>
                <form method="POST" action="{{ route('updateEvent', $event)}}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="mx-5">
                            <div class="mb-3">
                                <h2 class="fs-5 fw-bold">Informações básicas</h2>
                                <p class="text-muted">Preencha as informações de título, email, website e outros.</p>
                            </div>

                            <div class="mb-3">
                                <label for="published">{{ __('Publicar evento') }}</label>
                                <div class="form-control">
                                    <input type="hidden" name="published" value="0">
                                    <input id="published" type="checkbox" name="published" value='1' @checked(old('1', $event->published )) autofocus>
                                    <small> Tornar o evento visível para usuários</small>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="name">{{ __('Nome do evento') }}
                                    <span style="color: red">*</span>
                                </label>
                                <div>
                                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', $event->name) }}" required autocomplete="name" autofocus>
                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="email">{{ __('E-mail do evento') }}
                                        <span style="color: red">*</span>
                                    </label>
                                    <div>
                                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email', $event->email) }}" required autocomplete="email" autofocus>
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                        
                                <div class="col-md-6">
                                    <label for="website">{{ __('Site do evento') }}
                                        <span style="color: red">*</span>
                                    </label>
                                    <div>
                                        <input id="website" type="url" class="form-control @error('website') is-invalid @enderror" name="website" value="{{ old('website', $event->website) }}" required autocomplete="website" autofocus>
                                        @error('website')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="information">{{ __('Informações do evento') }}
                                    <span style="color: red">*</span>
                                </label>
                                <div>
                                    <textarea id="information" type="text" class="form-control @error('information') is-invalid @enderror" rows="10" name="information" required autocomplete="information" autofocus>{{ old('information', $event->information) }}</textarea>

                                    @error('information')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="name">{{ __('Ícone do evento') }}</label>
                                <div>
                                    <input id="logo" type="file" class="form-control @error('logo') is-invalid @enderror" name="logo" value="{{ old('logo') }}" accept="image/png, image/jpeg, image/jpg">
                                    <small class="text-muted">Arquivos permitidos: .jpg, .png, .jpeg.</small>

                                    @error('logo')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div>
                                    <a href="#" data-bs-toggle="modal" data-bs-target="#logoPrompt">
                                        <i class="fa-regular fa-image"></i> Ver ícone atual
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="mx-5">
                            <div class="mb-3">
                                <h2 class="fs-5 fw-bold">Datas e prazos</h2>
                                <p class="text-muted">Preencha as informações as datas de inicio do evento, prazos de inscrição e submissão.</p>
                            </div>
                        
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="subscription_start">{{ __('Início das inscrições') }}
                                        <span style="color: red">*</span>
                                    </label>
                                    <div>
                                        <input id="subscription_start" type="date" class="form-control @error('subscription_start') is-invalid @enderror" name="subscription_start" value="{{ old('subscription_start', formatYMD($event->subscription_start)) }}" required autocomplete="subscription_start" autofocus>
                                        @error('subscription_start')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                        <small class="text-muted">Inicia às 00:00:00</small>
                                    </div>
                                </div>
                        
                                <div class="col-md-6">
                                    <label for="subscription_deadline">{{ __('Fim das inscrições') }}
                                        <span style="color: red">*</span>
                                    </label>
                                    <div>
                                        <input id="subscription_deadline" type="date" class="form-control @error('subscription_deadline') is-invalid @enderror" name="subscription_deadline" value="{{ old('subscription_deadline', formatYMD($event->subscription_deadline)) }}" required autocomplete="subscription_deadline" autofocus>
                                        @error('subscription_deadline')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                        <small class="text-muted">Encerra às 23:59:59</small>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="submission_start">{{ __('Início das submissões') }}
                                        <span style="color: red">*</span>
                                    </label>
                                    <div>
                                        <input id="submission_start" type="date" class="form-control @error('submission_start') is-invalid @enderror" name="submission_start" value="{{ old('submission_start', formatYMD($event->submission_start)) }}" required autocomplete="submission_start" autofocus>
                                        @error('submission_start')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                        <small class="text-muted">Inicia às 00:00:00</small>
                                    </div>
                                </div>
                        
                                <div class="col-md-6">
                                    <label for="submission_deadline">{{ __('Fim das submissões') }}
                                        <span style="color: red">*</span>
                                    </label>
                                    <div>
                                        <input id="submission_deadline" type="date" class="form-control @error('submission_deadline') is-invalid @enderror" name="submission_deadline" value="{{ old('submission_deadline', formatYMD($event->submission_deadline)) }}" required autocomplete="submission_deadline" autofocus>
                                        @error('submission_deadline')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                        <small class="text-muted">Encerra às 23:59:59</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mx-5">
                            <div class="mb-3">
                                <h2 class="fs-5 fw-bold">Submissão</h2>
                                <p class="text-muted">Escolha os tipos de submissão do evento e a nota de corte para aprovação.</p>
                            </div>
                        
                            <div class="mb-3">
                                <label for="submission_type">{{ __('Tipos de submissão') }}
                                    <span style="color: red">*</span>
                                </label>
                                <div id="submission_type" class="form-control @error('submission_type') is-invalid @enderror">
                                    @foreach($types as $type)
                                        <div>
                                            <input type="checkbox"  name="submission_type[]" value="{{$type->id}}" @checked($event->submissionTypes->contains($type->id))>
                                            <small>{{ ucfirst($type->name) }}</small>
                                        </div>
                                    @endforeach
                                </div>
                                @error('submission_type')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="passing_grade">{{ __('Nota de corte') }}
                                    <span style="color: red">*</span>
                                </label>
                                <div>
                                    <input id="passing_grade" type="number" min="0" max="10" class="form-control @error('passing_grade') is-invalid @enderror" name="passing_grade" value="{{ old('passing_grade', $event->passing_grade) }}" required autofocus>
                                    @error('passing_grade')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                @error('passing_grade')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                <small class="form-text text-muted">A nota deve ser entre 0-10, as avaliações acima dessa nota serão aprovadas e as abaixo serão reprovadas.</small>
                            </div>
                        </div>

                        <div class="mx-5">
                            <div class="mb-3">
                                <h2 class="fs-5 fw-bold">Informações do organizador</h2>
                                <p class="text-muted">Preencha as informações do nome, email e website da instituição organizadora.</p>
                            </div>
                        
                            <div class="mb-3">
                                <label for="organizer">{{ __('Instituição organizadora') }}
                                    <span style="color: red">*</span>
                                </label>
                                <div>
                                    <input id="organizer" type="text" class="form-control @error('organizer') is-invalid @enderror" name="organizer" value="{{ old('organizer', $event->organizer) }}" required autocomplete="organizer" autofocus>
                                    @error('organizer')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="organizer_email">{{ __('E-mail do organizador') }}
                                        <span style="color: red">*</span>
                                    </label>
                                    <div>
                                        <input id="organizer_email" type="text" class="form-control @error('organizer_email') is-invalid @enderror" name="organizer_email" value="{{ old('organizer_email', $event->organizer_email) }}" required autocomplete="organizer_email" autofocus>
                                        @error('organizer_email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                        
                                <div class="col-md-6">
                                    <label for="organizer_website">{{ __('Site do organizador') }}
                                        <span style="color: red">*</span>
                                    </label>
                                    <div>
                                        <input id="organizer_website" type="url" class="form-control @error('organizer_website') is-invalid @enderror" name="organizer_website" value="{{ old('organizer_website', $event->organizer_website) }}" required autocomplete="organizer_website" autofocus>
                                        @error('organizer_website')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="d-grid col-5 mx-auto">
                                <a href="{{ url()->previous()}}" class="btn btn-outline-dark">
                                    Voltar
                                </a>
                            </div>
                            <div class="d-grid col-5 mx-auto">
                                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#editPrompt">
                                    {{ __('Salvar alterações') }}
                                </button>
                            </div>
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
                                    <p>Deseja confirmar as alterações no evento <strong>{{$event->name}}</strong> ?</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                    <form action="{{ route('updateEvent', $event)}}" method="POST">
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
                    <div class="modal fade" id="logoPrompt" tabindex="-1" aria-labelledby="logoLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Logo atual</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <img src="{{asset('storage/'.$event->logo)}}" alt="Logo do evento" width="100%"/>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Ok</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
