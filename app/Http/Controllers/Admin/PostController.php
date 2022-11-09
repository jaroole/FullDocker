<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(){
        return 'Страница рассылок';
    }
    public function create(){

        return 'Страница создания рассылки';
    }
    public function store(Request $request){

        $title=$request->input('title');
        $content=$request->input('content');
      

        dd($title, $content);
        return 'Страница сохранения рассылки';
    }
    public function show($post){
        return "Страница показа рассылок {$post}";
    }
    public function edit($post){
        return "Страница редактирования рассылок {$post}";
    }
    public function update(){
        return 'Страница обновления рассылок';
    }
    public function delete(){
        return 'Страница удаления рассылки';
    }
    public function like(){
        return ' лайка+1';
    }


}

