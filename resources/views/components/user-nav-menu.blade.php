@props(['user'])

@role(['user', 'admin'])
<nav class="mb-3 navbar navbar-expand navbar-light bg-white py-0 border-bottom">
    <ul class="navbar-nav me-auto">
        <li class="nav-item my-auto">
            <a href="{{route('indexSubscribed', $user)}}" class="nav-item nav-link">Ver inscrições</a>
        </li>
        <li class="nav-item my-auto">
            <a href="{{route('indexSubmissions', $user)}}" class="nav-item nav-link">Ver submissões</a>
        </li>
        <li class="nav-item my-auto">
            <a href="{{route('editUser', $user)}}" class="nav-item nav-link">Editar dados</a>
        </li>
        <li class="nav-item my-auto">
            <a href="{{route('editPassword', $user)}}" class="nav-item nav-link">Alterar Senha</a>
        </li>
    </ul>
</nav>
@else
<nav class="mb-3 navbar navbar-expand navbar-light bg-white py-0 border-bottom">
    <ul class="navbar-nav me-auto">
        <li class="nav-item my-auto">
            <a href="{{route('editUser', $user)}}" class="nav-item nav-link">Editar dados</a>
        </li>
        <li class="nav-item my-auto">
            <a href="{{route('editPassword', $user)}}" class="nav-item nav-link">Alterar Senha</a>
        </li>
    </ul>
</nav>
@endif