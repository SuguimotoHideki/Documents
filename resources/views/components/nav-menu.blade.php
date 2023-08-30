@role('user')
    <li class="nav-item my-auto">
        <a href="{{ route('indexSubmissions', Auth::user())}}" class="nav-link">Minhas submissões</a>
    </li>
    <li class="nav-item my-auto">
        <a href="{{route('indexSubscribed', Auth::user())}}" class="nav-link">Minhas inscrições</a>
    </li>
@endif
@role('admin')
    <li class="nav-item my-auto">
        <a href="{{route('createEvent')}}" class="nav-link">Criar Evento</a>
    </li>
    <li class="nav-item my-auto">
        <a href="{{route('manageEvents')}}" class="nav-link">Gerenciar eventos</a>
    </li>
    <li class="nav-item my-auto">
        <a href="{{route('manageDocuments')}}" class="nav-link">Gerenciar submissões</a>
    </li>
    <li class="nav-item my-auto">
        <a href="{{route('manageUsers')}}" class="nav-link">Gerenciar usuários</a>
    </li>
@endif
@role('event moderator')
    <li class="nav-item my-auto">
        <a href="{{route('manageEvents')}}" class="nav-link">Gerenciar eventos</a>
    </li>
    <li class="nav-item my-auto">
        <a href="{{route('manageDocuments')}}" class="nav-link">Gerenciar submissões</a>
    </li>
    <li class="nav-item my-auto">
        <a href="{{route('manageUsers')}}" class="nav-link">Gerenciar usuários</a>
    </li>
@endif
