@props(['wordList'])

@php
    $listItems = explode(',', $wordList);
@endphp

<ul class="mb-0 list-unstyled text-muted">
    @foreach ($listItems as $item)
        <li>{{$item}}</li>
    @endforeach
</ul>