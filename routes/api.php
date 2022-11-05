<?php

use App\Http\Controllers\Api\PostController;
use App\Models\Currency;
use App\Models\Post;
use GuzzleHttp\Psr7\Uri;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;


Route::get('posts', [PostController::class, 'index'])->name('posts');
Route::get('posts/{post}', [PostController::class, 'show'])->name('posts.show');
Route::get('posts/{post}/like', [PostController::class, 'like'])->name('posts.like');



// Route::get('currency', function(){

//     return Currency::first();
// });

// Route::get('currency', function(){

//     \Illuminate\Support\Facades\Http::post(Uri:'https://api.tlgr.org/bot5620620072:AAGriRMadgmzXSg3FKpB8psK9caN-HqBAP0/sendMessage'. [
//         'chat_id'=> 902325136,
//         'text' => 'Hellow bro'
//     ]);
// });

    //return Post::first();
    //return Redirect::away($url);
    // $data=request();
    // file_put_contents('file.txt', '$data: '.print_r($data, 1)."\n", FILE_APPEND);
    // return Request::sendMessage("https://api.telegram.org/bot5620620072:AAGriRMadgmzXSg3FKpB8psK9caN-HqBAP0/sendMessage?chat_id=902325136&text=Привет%20мир");
    // return request();



    //https://api.telegram.org/bot<Bot_token>/sendMessage?chat_id=<chat_id>&text=Привет%20мир
    //5620620072:AAGriRMadgmzXSg3FKpB8psK9caN-HqBAP0

    // Read File



// });

