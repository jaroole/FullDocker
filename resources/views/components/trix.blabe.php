
@props(['name' => ''])


<x-input id="content" type="hidden" name="content"/>
        <trix-editor input="content"></trix-editor>



@once
    @push('css')
    <link rel="stylesheet" href="/css/trix.css">
    @endpush

    @push('js')
    <script src="/js/trix.js"></script>
    @endpush
@endonce