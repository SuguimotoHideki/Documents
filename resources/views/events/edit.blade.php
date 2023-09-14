@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">{{ __('Editar evento') }}</div>

                <div class="card-body">
                    <form method="POST" action="/events/{{$event->id}}/update">
                        @csrf
                        @method('PUT')
                        <div class="row mb-3">
                            <label for="event_name" class="col-md-3 col-form-label text-md-center">{{ __('Nome do evento') }}
                                <span style="color: red">*</span>
                            </label>
                            <div class="col-md-8">
                                <input id="event_name" type="text" class="form-control @error('event_name') is-invalid @enderror" name="event_name" value="{{ old('event_name', $event->event_name) }}" required autocomplete="event_name" autofocus>

                                @error('event_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="event_email" class="col-md-3 col-form-label text-md-center">{{ __('E-mail do evento') }}
                                <span style="color: red">*</span>
                            </label>
                            <div class="col-md-8">
                                <input id="event_email" type="email" class="form-control @error('event_email') is-invalid @enderror" name="event_email" value="{{ old('event_email', $event->event_email) }}" required autocomplete="event_email" autofocus>

                                @error('event_email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="event_website" class="col-md-3 col-form-label text-md-center">{{ __('Site do evento') }}
                                <span style="color: red">*</span>
                            </label>
                            <div class="col-md-8">
                                <input id="event_website" type="url" class="form-control @error('event_website') is-invalid @enderror" name="event_website" value="{{ old('event_website', $event->event_website) }}" required autocomplete="event_website" autofocus>

                                @error('event_website')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="organizer" class="col-md-3 col-form-label text-md-center">{{ __('Organizador') }}
                                <span style="color: red">*</span>
                            </label>
                            <div class="col-md-8">
                                <input id="organizer" type="text" class="form-control @error('organizer') is-invalid @enderror" name="organizer" value="{{ old('organizer', $event->organizer) }}" required autocomplete="organizer" autofocus>

                                @error('organizer')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="organizer_email" class="col-md-3 col-form-label text-md-center">{{ __('E-mail do organizador') }}
                                <span style="color: red">*</span>
                            </label>
                            <div class="col-md-8 my-auto">
                                <input id="organizer_email" type="text" class="form-control @error('organizer_email') is-invalid @enderror" name="organizer_email" value="{{ old('organizer_email', $event->organizer_email) }}" required autocomplete="organizer_email" autofocus>

                                @error('organizer_email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="organizer_website" class="col-md-3 col-form-label text-md-center">{{ __('Site do organizador') }}
                                <span style="color: red">*</span>
                            </label>
                            <div class="col-md-8 my-auto">
                                <input id="organizer_website" type="url" class="form-control @error('organizer_website') is-invalid @enderror" name="organizer_website" value="{{ old('organizer_website', $event->organizer_website) }}" required autocomplete="organizer_website" autofocus>

                                @error('organizer_website')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="event_information" class="col-md-3 col-form-label text-md-center">{{ __('Informações do evento') }}
                                <span style="color: red">*</span>
                            </label>
                            <div class="col-md-8">
                                <textarea id="event_information" type="text" class="form-control @error('event_information') is-invalid @enderror" rows="10" name="event_information" required autocomplete="event_information" autofocus>{{ old('event_information', $event->event_information) }}</textarea>

                                @error('event_information')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="paper_topics" class="col-md-3 col-form-label text-md-center">{{ __('Tópicos de artigo (Separado por vírgula)') }}
                                <span style="color: red">*</span>
                            </label>
                            <div class="col-md-8 my-auto">
                                <textarea id="paper_topics" type="text" class="form-control @error('paper_topics') is-invalid @enderror" rows="10" name="paper_topics" placeholder="Exemplo: Saúde, Meio-Ambiente, Doenças, etc" required autocomplete="paper_topics" autofocus>{{ old('paper_topics', $event->paper_topics) }}</textarea>

                                @error('paper_topics')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="subscription_start" class="col-md-3 col-form-label text-md-center">{{ __('Inicio das inscrições') }}
                                <span style="color: red">*</span>
                            </label>
                            <div class="col-md-8 my-auto">
                                <div class="row">
                                    <div class="col-md-6 my-auto">
                                        <input id="subscription_start" type="date" class="form-control @error('subscription_start') is-invalid @enderror" name="subscription_start" value="{{ old('subscription_start', $event->subscription_start) }}" required autocomplete="subscription_start" autofocus>
                                        <small class="form-text text-muted">Data inicial</small>

                                        @error('subscription_start')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 my-auto">
                                        <input id="subscription_deadline" type="date" class="form-control @error('subscription_deadline') is-invalid @enderror" name="subscription_deadline" value="{{ old('subscription_deadline', $event->subscription_deadline) }}" required autocomplete="subscription_deadline" autofocus>
                                        <small class="form-text text-muted">Data final</small>

                                        @error('subscription_deadline')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="submission_start" class="col-md-3 col-form-label text-md-center">{{ __('Inicio das submissões') }}
                                <span style="color: red">*</span>
                            </label>
                            <div class="col-md-8 my-auto">
                                <div class="row">
                                    <div class="col-md-6 my-auto">
                                        <input id="submission_start" type="date" class="form-control @error('submission_start') is-invalid @enderror" name="submission_start" value="{{ old('submission_start', $event->submission_start) }}" required autocomplete="submission_start" autofocus>
                                        <small class="form-text text-muted">Data inicial</small>

                                        @error('submission_start')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 my-auto">
                                        <input id="submission_deadline" type="date" class="form-control @error('submission_deadline') is-invalid @enderror" name="submission_deadline" value="{{ old('submission_deadline', $event->submission_deadline) }}" required autocomplete="submission_deadline" autofocus>
                                        <small class="form-text text-muted">Data final</small>

                                        @error('submission_deadline')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="event_status" class="col-md-3 col-form-label text-md-center">{{ __('Status do evento') }}
                                <span style="color: red">*</span>
                            </label>
                            <div class="col-md-8 my-auto">
                                <select name="event_status" id="event_status" class="col-md-12 my-auto">
                                    <option value="0" {{ $event->event_status === 'Em breve' ? 'selected' : '' }}>Em breve</option>
                                    <option value="6" {{ $event->event_status === 'Adiado' ? 'selected' : '' }}>Adiado</option>
                                    <option value="7" {{ $event->event_status === 'Cancelado' ? 'selected' : '' }}>Cancelado</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="event_published" class="col-md-3 col-form-label text-md-center">{{ __('Evento publicado') }}</label>
                            <div class="col-md-8 my-auto">
                                <input id="event_published" type="checkbox" name="event_published" value='1' @checked(old('1', $event->event_published )) autofocus>
                                <small class="form-text text-muted">Tornar o evento visível para usuários</small>
                            </div>
                        </div>
                        <div class="modal fade" id="editPrompt" tabindex="-1" aria-labelledby="editPromptLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">{{$event->event_name}}</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p>Deseja confirmar as alterações em <strong>{{$event->event_name}}</strong> ?</p>
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
                    </form>
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
            </div>
        </div>
    </div>
</div>

@endsection
