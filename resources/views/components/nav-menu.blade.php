@role('user')
    <li class="nav-item my-auto">
        <a href="{{ route('indexSubmissions', Auth::user())}}" class="nav-link">Minhas submissões</a>
    </li>
    <li class="nav-item my-auto">
        <a href="{{ route('indexSubscribed', Auth::user())}}" class="nav-link">Minhas inscrições</a>
    </li>
@endif
@role('admin')
    <li class="nav-item dropdown">
        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
            {{ "Eventos" }}
        </a>
        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
            <a class="dropdown-item btn rounded-0" href="{{ route('createEvent')}}">
                {{"Criar evento"}}
            </a>
            <a class="dropdown-item btn rounded-0" href="{{ route('manageEvents')}}">
                {{"Gerenciar"}}
            </a>
            <a class="dropdown-item btn rounded-0" href="{{ route('indexSubType')}}">
                {{"Tipos de submissão"}}
            </a>
        </div>
    </li>
    <li class="nav-item my-auto">
        <a href="{{route('manageDocuments')}}" class="nav-link">Submissões</a>
    </li>
    <li class="nav-item dropdown">
        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
            {{ "Avaliações" }}
        </a>
        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
            <a class="dropdown-item btn rounded-0" href="{{ route('manageReviews')}}">
                {{"Gerenciar"}}
            </a>
            <a class="dropdown-item btn rounded-0" href="{{ route('indexReviewFields')}}">
                {{"Critérios de avaliação"}}
            </a>
        </div>
    </li>
    <li class="nav-item my-auto">
        <a href="{{route('manageUsers')}}" class="nav-link">Usuários</a>
    </li>
    <li class="nav-item my-auto icon-badge-group">
        <a href="{{route('indexUnread')}}" class="nav-link item">Notificações <div class="notify-badge">{{Auth::user()->unreadNotifications()->groupBy('notifiable_type')->count()}}</div></a>
    </li>
@endif
@role('event moderator')
    <li class="nav-item my-auto">
        <a href="{{route('manageEvents')}}" class="nav-link">Eventos</a>
    </li>
    <li class="nav-item my-auto">
        <a href="{{route('manageDocuments')}}" class="nav-link">Submissões</a>
    </li>
    <li class="nav-item my-auto">
        <a href="{{route('manageUsers')}}" class="nav-link">Usuários</a>
    </li>
@endif
@role('reviewer')
    <li class="nav-item my-auto">
        <a href="{{route('manageDocuments')}}" class="nav-link">Submissões</a>
    </li>
    <li class="nav-item my-auto">
        <a href="{{route('manageReviews')}}" class="nav-link">Avaliações</a>
    </li>
@endif
