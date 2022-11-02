<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    public function index(){

        $posts=DB::select('select * from posts where user_id = ?', [session()->get('userSessionId')]);
        return view('user.posts.index', compact('posts'));
    }


    public function create(){
        return view('user.posts.create');
    }


    public function store(Request $request){
        
        $title=$request->input('title');
        $content=$request->input('content');
        DB::insert('insert into posts (title, content, user_id) values (?, ?, ?)', [$title, $content, session()->get('userSessionId')]);

       
        alert(__('Сохранено'));
       return redirect()->route('user.posts', session()->get('userSessionId'));
    }




    public function show($post){
        

        $post=DB::select('select * from posts where id = ? AND user_id = ?', [$post, session()->get('userSessionId')]);
        $post = json_decode(json_encode($post), true);
        $post=$post['0'];

        //$post=['id'=>1012, 'title'=>'тест', 'content'=>'нет'];

       //dd($post);
       //dd($post2);

            
        return view('user.posts.show', compact('post'));
    }




    public function edit($post){


        $post=DB::select('select * from posts where id = ?', [$post]);
        $post = json_decode(json_encode($post), true);
        $post=$post['0'];
        //dd($post);

        // $post=(object)[
        //     'id'=>$post,
        //     'title'=>'Lorem ipsum dolor sit amet.',
        //     'content'=>'Lorem ipsum <strong>dolor</strong> sit amet consectetur adipisicing elit. Amet, fugit?',
        // ];
       
        return view('user.posts.edit', compact('post'));

     
       
    }



    public function update(Request $request, $post){

        $title=$request->input('title');
        $content=$request->input('content');



   
        DB::update(
            'update posts set title = ? , content = ? where user_id = ? AND id = ?',
            [$title, $content, session()->get('userSessionId'), $post]);
        
        

        // dd($title, $content);
        // return 'Страница обновления постов';

        // return redirect()->route('user.posts.show', $post);
        alert(__('Сохранено'));
        return redirect()->route('user.posts');
    }



    public function delete($post){
        // return 'Страница удаления постов';
       
        DB::delete('delete from posts where id = ?', [$post]);
       
        
        alert(__('Удалено'));
        return redirect()->route('user.posts');
    }



    public function like(){
        return ' лайка+1';
    }
    // public function create(){
    //     return 'Страница списка постов';
    // }

}

