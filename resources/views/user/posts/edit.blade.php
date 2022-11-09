@extends('layouts.main')
@section('page.title', 'Изменить рассылку')
@section('main.content')
        <x-title>
            {{__('Изменит рассылку')}}
            <x-slot name="link">
                <a href="{{route('user.posts')}}">
                {{__('Назад')}}
                </a>
        
               </x-slot>
        </x-title>

 
        
        <x-post.form action="{{route('user.posts.update', $post['id'])}}" method="put" :post="$post">
            <x-button type="submit" >
                {{__('Сохранить')}}
            </x-button>

        </x-post.form>
   

@endsection

