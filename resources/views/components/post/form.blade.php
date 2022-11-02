@props(['post'=>null])

<x-form {{$attributes}} > 
    <x-form-item>
        <x-label required> {{__('Название поста')}} </x-label>
        <x-input name="title" value="{{$post->title ?? ''}}" />
    </x-form-item>

    <x-form-item>
        <x-label required> {{__('Название поста')}} </x-label>
        <x-input id="content" value="{{$post->content ?? ''}}" type="hidden" name="content"/>
        <trix-editor input="content"></trix-editor>
        
        
        {{-- <x-trix name="content" /> --}}

    </x-form-item>

    {{$slot}}


</x-form>


@once
    @push('css')
    <link rel="stylesheet" href="/css/trix.css">
    @endpush

    @push('js')
    <script src="/js/trix.js"></script>
    @endpush
@endonce