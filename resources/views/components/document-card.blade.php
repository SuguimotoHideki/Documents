@props(['document'])

<div class="bg-gray-50 border border-gray-200 rounded p-6">
    <div class="flex">
        <div>
            <h3 class="text-xl fw-bold">
                <a href="/documents/{{$document->id}}">{{$document->title}}</a>
            </h3>
            <div class="text-lg">
                {{$document->author}}
            </div>
            <div class="mt-1">
                <x-document-keywords : keywordCsv="{{$document->keyword}}"/>
            </div>
        </div>
    </div>
</div>