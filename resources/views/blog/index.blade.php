@extends('layouts.main')
@section('page.title', 'Рассылки')
@section('main.content')
        <x-title>
            {{__('Рассылки')}}

        </x-title>

        @include('blog.filter')





        @if(empty($posts))
        {{__('Нет ни одной рассылки')}}
        
        @else
            <div class="row">

                    @foreach ($posts as $post)
                    <div class="col-12 col-md-4">
                        <x-post.card :post="$post"/>
                    </div>
                    @endforeach
            </div>

        
        @endif
   

@endsection
   


