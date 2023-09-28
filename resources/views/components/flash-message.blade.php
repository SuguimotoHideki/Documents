@if(session()->has('success'))
    <div x-data="{show: true}" x-init="" x-show="show" class="text-center alert alert-success align-middle">
        <strong>Sucesso! </strong>{{session('success')}}
    </div>
@elseif(session()->has('error'))
    <div x-data="{show: true}" x-init="" x-show="show" class="text-center alert alert-danger align-middle">
        <strong>Erro! </strong>{{session('error')}}
    </div>
@elseif(session()->has('warning'))
    <div x-data="{show: true}" x-init="" x-show="show" class="text-center alert alert-warning align-middle">
        <strong>Aviso! </strong>{{session('warning')}}
    </div>
@endif