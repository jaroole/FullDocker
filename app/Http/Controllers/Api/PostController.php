<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(){
        return 'Страница списка рассылки';
    }
    public function create(){
        return 'Страница создания рассылки';
    }
    public function store(){
        return 'Страница сохранения рассылки';
    }
    public function show($post){
        return "Страница рассылки {$post}";
    }
    public function edit($post){
        return "Страница редактирования рассылки {$post}";
    }
    public function update(){
        return 'Страница обновления рассылки';
    }
    public function delete(){
        return 'Страница удаления рассылки';
    }
    public function like(){
        return ' лайка+1';
    }


}

