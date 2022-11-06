<?php

use App\Http\Controllers\BlogController;
use App\Http\Controllers\BotController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\Post\CommentController;
use App\Http\Controllers\User\PostController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\TestController;
use GuzzleHttp\Psr7\Uri;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|





*/

// Route::get('/', function () {
//     return view('welcome');
// });


Route::any('/bot', [BotController::class, 'index']);
// Route::any('/bot', function(\App\Telegram\Telegram $telegram){
//     $buttons = [
//         'inline_keyboard' => [
//             [
//                 [
//                     'text'=>'button1',
//                     'callback_data'=> '1',

//                 ],
//                 [
//                     'text'=>'button2',
//                     'callback_data'=> '2',

//                 ]
//             ]
//             ]
//         ];

//     $sendMessage = $telegram -> sendButtons(902325136, 'test', json_encode($buttons));
//     $sendMessage = json_decode($sendMessage);
//     dd($sendMessage);

    
// });

// Route::any('/bot', function(){

//     Illuminate\Support\Facades\Http::post('https://api.tlgr.org/bot5620620072:AAGriRMadgmzXSg3FKpB8psK9caN-HqBAP0/sendMessage', [
//         'chat_id'=> 902325136,
//         'text' => '<b>Hellow<b> from newapi',
//         'parse_mode' => 'html',
//     ]);
// });



Route::view('/', 'home.index')->name('home');

Route::redirect('/home', '/');

Route::get('/test', TestController::class)->name('test');

Route::middleware('guest')->group(function(){

Route::get('register', [RegisterController::class, 'index'])->name('register');
Route::post('register', [RegisterController::class, 'store'])->name('register.store');


Route::get('login', [LoginController::class, 'index'])->name('login');
Route::post('login', [LoginController::class, 'store'])->name('login.store');

});

// Route::get('login/{user}/confirmation', [LoginController::class, 'confirmation'])->name('login.confirmation');
// Route::post('login/{user}/confirm', [LoginController::class, 'confirmation'])->name('login.confirm');

Route::get('blog', [BlogController::class, 'index'])->name('blog');
Route::get('blog/{post}', [BlogController::class, 'show'])->name('blog.show');
Route::post('blog/{post}/like', [BlogController::class, 'like'])->name('blog.like');

//CRUD (create, read, update, delete)



Route::resource('posts/{post}/comments', CommentController::class);
// Route::resource('posts', PostController::class)->only(['index', 'show']);


// Route::fallback(function(){
//     return 'Fallback';
// });