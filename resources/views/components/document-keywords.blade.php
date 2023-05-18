@props(['keywordCsv'])

@php
    $keywords = explode(',', $keywordCsv);
@endphp

<ul class="flex">
    @foreach ($keywords as $keyword)
        <li class="flex items-center justify-center bg-black text-white rounded-5 py-1 px-3 mr-2 text-xs">
            {{$keyword}}
        </li>
    @endforeach
</ul>