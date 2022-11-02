@extends('layouts.main')
@section('page.title', 'Просмотр поста')
@section('main.content')
       

        <x-title>
            <x-slot name="link">
                    <a href="{{route('user.posts')}}">
                        {{__('Назад')}}
                    </a>
            </x-slot>
        </x-title>


        <x-title>
            {{__('Просмотр поста')}}
            <x-slot name="right">
                    <x-button-link href="{{route('user.posts.edit', $post['id'])}}">
                        {{__('Изменить')}}
                    </x-button-link>

                    
                    <x-post.delete action="{{route('user.posts.delete', $post['id'])}}" method="delete">

                        <x-button type="submit" size="sm" class="mb-3">
                            {{__('Удалить пост')}}
                        </x-button>
                    </x-post.delete>         
                    

                    

               
                    


            </x-slot>
        </x-title>

            <h2 class="h4">
               
                    {{$post['title']}}

               


            </h2>
            <div class="small text-muted">
                {{$post['created_at']}}
            </div>

            <div class="pt-3">
                {!!$post['content']!!}
        
        
               </div>
        </div>
       
   

@endsection
   