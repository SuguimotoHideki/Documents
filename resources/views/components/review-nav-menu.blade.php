@props(['document', 'review'])

<div class="col-md-3 mb-2">
    <div class="shadow-sm p-3 bg-white h-100">
        <div class="fw-bold fs-4 mb-2 border-bottom">
            <a href="{{route('showReview', [$document, $review])}}">Avaliação</a>
        </div>
        <ul class="nav flex-column mb-auto">
            <li class="mb-2">
                <a href="{{route('showDocument', $document)}}" class="btn btn-light w-100 py-2 text-start">
                    <i class="fa-solid fa-file-lines"></i> Ver submissão
                </a>
            </li>
            <li class="mb-2">
                <a href="{{route('editReview', [$document, $review])}}" class="btn btn-light w-100 py-2 text-start">
                    <i class="fa-solid fa-pen-to-square"></i> Editar avaliação
                </a>
            </li>
            <li class="mb-2">
                <a data-bs-toggle="modal" data-bs-target="#reviewDeletePrompt{{$review->id}}" class="btn btn-light w-100 py-2 text-start">
                    <i class="fa-solid fa-trash-can"></i> Excluir avaliação
                </a>
            </li>
        </ul>
    </div>
</div>


<div class="modal fade" id="reviewDeletePrompt{{$review->id}}" tabindex="-1" aria-labelledby="reviewDeletePromptLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Excluir avaliação</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Deseja excluir a avaliação da submissão <strong>{{$document->title}}</strong> ?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <form action="{{ route('deleteReview', [$document, $review])}}" method="POST">
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