@props(['post'=>null])
@props(['method'=>'GET'])

@php($method = strtoupper($method))

@php($_method = in_array($method, ['GET', 'POST']))


<form {{$attributes}} method="{{$_method ? $method : 'POST'}}">

@unless($_method)

    @method($method)

@endunless


@if($method!=='GET')
@csrf 
@endif



    <x-button size="sm">
        {{$slot}}
    </x-button>


</form>

@once
    @push('css')
    <link rel="stylesheet" href="/css/trix.css">
    @endpush

    @push('js')
    <script src="/js/trix.js"></script>
    @endpush
@endonce