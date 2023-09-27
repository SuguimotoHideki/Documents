@props(['document'])

<div class="col-md-3">
    <div class="shadow-sm p-3 mb-5 bg-white h-100">
        <div class="fw-bold fs-4 mb-2 border-bottom">
            <a href="{{route('showDocument', $document)}}">Submissão</a>
        </div>
        <ul class="nav flex-column mb-auto">
            @can('submissions.edit')
                <li class="mb-2">
                    <a href="{{route('editDocument', $document)}}" class="btn btn-light w-100 py-2 text-start" aria-pressed="true">
                        <i class="fa-regular fa-pen-to-square"></i> Editar submissão
                    </a>
                </li>
            @endcan
            @can('reviews.index')
                <li class="mb-2">
                    <a href="{{route('indexByDocument', $document)}}" class="btn btn-light w-100 py-2 text-start">
                        <i class="fa-solid fa-table-list"></i> Ver avaliações
                    </a>
                </li>
            @endcan
            @can('reviews.manage')
                <li class="mb-2">
                    <a href="{{route('assignReviewer', $document)}}" class="btn btn-light w-100 py-2 text-start">
                        <i class="fa-solid fa-user"></i> Gerenciar avaliadores
                    </a>
                </li>
            @endcan
            @can('submissions.delete')
                <li class="mb-2">
                    <a data-bs-toggle="modal" data-bs-target="#documentDeletePrompt{{$document->id}}" class="btn btn-light w-100 py-2 text-start">
                        <i class="fa-solid fa-trash-can"></i> Excluir submissão
                    </a>
                </li>
            @endcan
            @role('reviewer')
                @php
                    $review = $document->review()->where('user_id', Auth::user()->id)->first();
                @endphp
                @if($review !== null)
                    <li class="mb-2">
                        <a href="{{route('showReview', [$document, $review])}}" class="btn btn-light w-100 py-2 text-start">
                            Ver avaliação
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="{{route('editReview', [$document, $review])}}" class="btn btn-light w-100 py-2 text-start">
                            Editar avaliação
                        </a>
                    </li>
                @else
                    <li class="mb-2">
                        <a href="{{route('createReview', $document)}}" class="btn btn-light w-100 py-2 text-start">
                            Avaliar
                        </a>
                    </li>
                @endif
            @endif
        </ul>
    </div>
</div>


<!--<nav class="mb-3 navbar navbar-expand navbar-light bg-white py-0 border-bottom">
    <div class="navbar-nav me-auto">
        @can('submissions.edit')
            <a href="{{route('editDocument', $document->id)}}" class="nav-item nav-link">Editar submissão</a>
        @endcan
        @can('reviews.index')
            <a href="{{ route('indexByDocument', $document->id)}}" class="nav-item nav-link">Ver avaliações</a>
        @endcan
        @can('reviews.manage')
            <a href="{{route('assignReviewer', $document->id)}}" class="nav-item nav-link">Adicionar avaliadores</a>
        @endcan
        @can('submissions.delete')
            <a href="#" class="nav-item nav-link" data-bs-toggle="modal" data-bs-target="#documentDeletePrompt{{$document->id}}">Excluir submissão</a>
        @endcan

        @role('reviewer')
            @php
                $review = $document->review()->where('user_id', Auth::user()->id)->first();
            @endphp
            @if($review !== null)
                <a href="{{route('showReview', [$document, $review])}}" class="nav-item nav-link">Ver avaliação</a>
                <a href="{{route('editReview', [$document, $review])}}" class="nav-item nav-link">Editar avaliação</a>
            @else
                <a href="{{route('createReview', $document)}}" class="nav-item nav-link">Avaliar</a>
            @endif
        @endif
    </div>
</nav>-->



<div class="modal fade" id="documentDeletePrompt{{$document->id}}" tabindex="-1" aria-labelledby="documentDeletePromptLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Excluir submissão</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Deseja excluir a submissão <strong>{{$document->title}}</strong> do evento <strong>{{$document->submission->event->name}}</strong> ?</p>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <form action="{{ route('deleteDocument', $document->id)}}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        {{ __('Excluir') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>