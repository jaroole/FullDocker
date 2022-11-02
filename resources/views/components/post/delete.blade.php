@props(['post'=>null])

<x-form {{$attributes}} > 
    <a>


    {{$slot}}

    </a>
</x-form>


@once
    @push('css')
    <link rel="stylesheet" href="/css/trix.css">
    @endpush

    @push('js')
    <script src="/js/trix.js"></script>
    @endpush
@endonce