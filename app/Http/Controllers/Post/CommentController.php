<?php

namespace App\Http\Controllers\Post;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CommentController extends Controller
{

    public function index($qa)
    {
        return "index {$qa}";
    }

        public function create($a)
    {
        return "create $a";
    }
    
    public function store(Request $request)
    {
        return "store";
    }

        public function show($a, $b)
    {
        return "show $a, $b";
    }

        public function edit($post, $comment)
    {
        return "Изменить комментарий {$comment} (Рассылка {$post})";
    }

    
    public function update(Request $request, $id)
    {
        //
    }

    
    public function destroy($id)
    {
        //
    }


}
