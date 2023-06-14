@if(session()->has('message'))
    <div x-data="{show: true}" x-init=""
        x-show="show" class="text-md-center bg-success px-48 align-middle text-white">
        <p class="py-2">
            {{session('message')}}
        </p>
    </div>
@endif

@if(session()->has('error'))
    <div x-data="{show: true}" x-init=""
        x-show="show" class="text-md-center bg-danger px-48 align-middle text-white">
        <p class="py-2">
            {{session('error')}}
        </p>
    </div>
@endif