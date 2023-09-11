@props(['document'])

@role(['admin'])
<nav class="mb-3 navbar navbar-expand navbar-light bg-white py-0 border-bottom">
    <div class="navbar-nav me-auto">
        <a href="{{route('editDocument', $document->id)}}" class="nav-item nav-link">Editar submissão</a>
        <a href="{{ route('indexByDocument', $document->id)}}" class="nav-item nav-link">Ver avaliações</a>
        <a href="{{route('assignReviewer', $document->id)}}" class="nav-item nav-link">Adicionar avaliadores</a>
    </div>
</nav>
@elseif(Auth::user()->hasRole('event moderator'))
<nav class="mb-3 navbar navbar-expand navbar-light bg-white py-0 border-bottom">
    <div class="navbar-nav me-auto">
        <a href="{{ route('indexByDocument', $document->id)}}" class="nav-item nav-link">Ver avaliações</a>
        <a href="{{route('assignReviewer', $document->id)}}" class="nav-item nav-link">Adicionar avaliadores</a>
    </div>
</nav>
@elseif(Auth::user()->hasRole('reviewer'))
<nav class="mb-3 navbar navbar-expand navbar-light bg-white py-0 border-bottom">
    <div class="navbar-nav me-auto">
        @php
            $review = $document->review()->where('user_id', Auth::user()->id)->first();
        @endphp
        @if($review !== null)
            <a href="{{route('showReview', [$document, $review])}}" class="nav-item nav-link">Ver avaliação</a>
            <a href="{{route('editReview', [$document, $review])}}" class="nav-item nav-link">Editar avaliação</a>
        @else
            <a href="{{route('createReview', $document)}}" class="nav-item nav-link">Avaliar</a>
        @endif
    </div>
</nav>
@elseif(Auth::user()->hasRole('user'))
<nav class="mb-3 navbar navbar-expand navbar-light bg-white py-0 border-bottom">
    <div class="navbar-nav me-auto">
        <a href="{{ route('editDocument', $document->id)}}" class="nav-item nav-link">Editar submissão</a>
        <a href="{{ route('indexByDocument', $document->id)}}" class="nav-item nav-link">Ver avaliações</a>
    </div>
</nav>
@endcan