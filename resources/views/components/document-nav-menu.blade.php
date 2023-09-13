@props(['document'])

<nav class="mb-3 navbar navbar-expand navbar-light bg-white py-0 border-bottom">
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
</nav>