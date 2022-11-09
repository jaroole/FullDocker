@extends('layouts.main')
@section('page.title', 'Создать рассылку')
@section('main.content')
        <x-title>
            {{__('Создать рассылку')}}
            <x-slot name="link">
                <a href="{{route('user.posts')}}">
                {{__('Назад')}}
                </a>
        
               </x-slot>
        </x-title>

 
        
        <x-post.form action="{{route('user.posts.store')}}" method="post">

            <x-button type="submit">
                {{__('Создать рассылку')}}
            </x-button>
        </x-post.form>
   

@endsection
