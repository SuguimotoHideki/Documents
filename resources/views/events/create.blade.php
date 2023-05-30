@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">{{ __('Publicar evento') }}</div>

                <div class="card-body">
                    <form method="POST" action="/events">
                        @csrf
                        <div class="row mb-3">
                            <label for="event_name" class="col-md-3 col-form-label text-md-center">{{ __('Nome do evento') }}</label>
                            <div class="col-md-8">
                                <input id="event_name" type="text" class="form-control @error('event_name') is-invalid @enderror" name="event_name" value="{{ old('event_name') }}" required autocomplete="event_name" autofocus>

                                @error('event_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="event_email" class="col-md-3 col-form-label text-md-center">{{ __('E-mail do evento') }}</label>
                            <div class="col-md-8">
                                <input id="event_email" type="email" class="form-control @error('event_email') is-invalid @enderror" name="event_email" value="{{ old('event_email') }}" required autocomplete="event_email" autofocus>

                                @error('event_email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="event_website" class="col-md-3 col-form-label text-md-center">{{ __('Site do evento') }}</label>
                            <div class="col-md-8">
                                <input id="event_website" type="url" class="form-control @error('event_website') is-invalid @enderror" name="event_website" value="{{ old('event_website') }}" required autocomplete="event_website" autofocus>

                                @error('event_website')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="organizer" class="col-md-3 col-form-label text-md-center">{{ __('Organizador') }}</label>
                            <div class="col-md-8">
                                <input id="organizer" type="text" class="form-control @error('organizer') is-invalid @enderror" name="organizer" value="{{ old('organizer') }}" required autocomplete="organizer" autofocus>

                                @error('organizer')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="organizer_email" class="col-md-3 col-form-label text-md-center">{{ __('E-mail do organizador') }}</label>
                            <div class="col-md-8 my-auto">
                                <input id="organizer_email" type="text" class="form-control @error('organizer_email') is-invalid @enderror" name="organizer_email" value="{{ old('organizer_email') }}" required autocomplete="organizer_email" autofocus>

                                @error('organizer_email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="organizer_website" class="col-md-3 col-form-label text-md-center">{{ __('Site do organizador') }}</label>
                            <div class="col-md-8 my-auto">
                                <input id="organizer_website" type="url" class="form-control @error('organizer_website') is-invalid @enderror" name="organizer_website" value="{{ old('organizer_website') }}" required autocomplete="organizer_website" autofocus>

                                @error('organizer_website')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="event_information" class="col-md-3 col-form-label text-md-center">{{ __('Informações do evento') }}</label>
                            <div class="col-md-8">
                                <textarea id="event_information" type="text" class="form-control @error('event_information') is-invalid @enderror" rows="10" name="event_information" required autocomplete="event_information" autofocus>{{ old('event_information') }}</textarea>

                                @error('event_information')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="paper_topics" class="col-md-3 col-form-label text-md-center">{{ __('Tópicos de artigo (Separado por vírgula)') }}</label>
                            <div class="col-md-8 my-auto">
                                <textarea id="paper_topics" type="text" class="form-control @error('paper_topics') is-invalid @enderror" rows="10" name="paper_topics" placeholder="Exemplo: Saúde, Meio-Ambiente, Doenças, etc" required autocomplete="paper_topics" autofocus>{{ old('paper_topics') }}</textarea>

                                @error('paper_topics')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="paper_tracks" class="col-md-3 col-form-label text-md-center">{{ __('Trilhas de artigo (Separado por vírgula)') }}</label>
                            <div class="col-md-8 my-auto">
                                <input id="paper_tracks" type="text" class="form-control @error('paper_tracks') is-invalid @enderror" name="paper_tracks" value="{{ old('paper_tracks') }}" placeholder="Exemplo: Saúde, Meio-Ambiente, Doenças, etc" required autocomplete="paper_tracks" autofocus>

                                @error('paper_tracks')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="start_date" class="col-md-3 col-form-label text-md-center">{{ __('Início do evento') }}</label>
                            <div class="col-md-8 my-auto">
                                <input id="start_date" type="date" class="form-control @error('start_date') is-invalid @enderror" name="start_date" value="{{ old('start_date') }}" required autocomplete="start_date" autofocus>

                                @error('start_date')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="end_date" class="col-md-3 col-form-label text-md-center">{{ __('Fim do evento') }}</label>
                            <div class="col-md-8 my-auto">
                                <input id="end_date" type="date" class="form-control @error('end_date') is-invalid @enderror" name="end_date" value="{{ old('end_date') }}" required autocomplete="end_date" autofocus>

                                @error('end_date')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="subscription_deadline" class="col-md-3 col-form-label text-md-center">{{ __('Prazo para inscrição') }}</label>
                            <div class="col-md-8 my-auto">
                                <input id="subscription_deadline" type="date" class="form-control @error('subscription_deadline') is-invalid @enderror" name="subscription_deadline" value="{{ old('subscription_deadline') }}" required autocomplete="subscription_deadline" autofocus>

                                @error('subscription_deadline')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="submission_deadline" class="col-md-3 col-form-label text-md-center">{{ __('Prazo para submissão') }}</label>
                            <div class="col-md-8 my-auto">
                                <input id="submission_deadline" type="date" class="form-control @error('submission_deadline') is-invalid @enderror" name="submission_deadline" value="{{ old('submission_deadline') }}" required autocomplete="submission_deadline" autofocus>

                                @error('submission_deadline')
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
