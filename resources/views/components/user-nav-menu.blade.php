@props(['user'])

<div class="col-md-3 mb-2">
    <div class="shadow-sm p-3 bg-white h-100">
        <div class="fw-bold fs-4 mb-2 border-bottom">
            <a href="{{route('showUser', $user)}}">Perfil</a>
        </div>
        <ul class="nav flex-column mb-auto">
            @if($user === Auth::user() || Auth::user()->hasRole('admin'))
                @if($user->hasRole('user'))
                    <li class="mb-2">
                        <a href="{{route('indexSubscribed', $user)}}" class="btn btn-light w-100 py-2 text-start" aria-pressed="true">
                            <i class="fa-solid fa-table-list"></i> Inscrições
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="{{route('indexSubmissions', $user)}}" class="btn btn-light w-100 py-2 text-start" aria-pressed="true">
                            <i class="fa-solid fa-file-lines"></i> Submissões
                        </a>
                    </li>
                @elseif($user->hasRole('event moderator'))
                    <li class="mb-2">
                        <a href="{{route('indexModerated', $user)}}" class="btn btn-light w-100 py-2 text-start" aria-pressed="true">
                            <i class="fa-solid fa-table-list"></i> Eventos moderados
                        </a>
                    </li>
                @elseif($user->hasRole('reviewer'))
                    <li class="mb-2">
                        <a href="" class="btn btn-light w-100 py-2 text-start" aria-pressed="true">
                            <i class="fa-solid fa-table-list"></i> Submissões avaliadas
                        </a>
                    </li>
                @endif
            @endif
            <li class="mb-2">
                <a href="{{route('editUser', $user)}}" class="btn btn-light w-100 py-2 text-start" aria-pressed="true">
                    <i class="fa-solid fa-pen-to-square"></i> Alterar dados
                </a>
            </li>
            <li class="mb-2">
                <a href="{{route('editPassword', $user)}}" class="btn btn-light w-100 py-2 text-start" aria-pressed="true">
                    <i class="fa-solid fa-key"></i> Alterar senha
                </a>
            </li>
        </ul>
    </div>
</div>