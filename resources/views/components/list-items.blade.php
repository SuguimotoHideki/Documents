@props(['wordList'])

@php
    $listItems = explode(',', $wordList);
@endphp

<ul class="mb-0">
    @foreach ($listItems as $item)
        <li>{{$item}}</li>
    @endforeach
</ul>