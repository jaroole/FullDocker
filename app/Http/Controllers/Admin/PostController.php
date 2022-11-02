<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(){
        return 'Страница списка постов';
    }
    public function create(){

        return 'Страница создания постов';
    }
    public function store(Request $request){

        $title=$request->input('title');
        $content=$request->input('content');
      

        dd($title, $content);
        return 'Страница сохранения постов';
    }
    public function show($post){
        return "Страница показа постов {$post}";
    }
    public function edit($post){
        return "Страница редактирования постов {$post}";
    }
    public function update(){
        return 'Страница обновления постов';
    }
    public function delete(){
        return 'Страница удаления постов';
    }
    public function like(){
        return ' лайка+1';
    }
    // public function create(){
    //     return 'Страница списка постов';
    // }

}

