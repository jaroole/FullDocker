<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Telegram\Telegram;
use Hamcrest\Arrays\IsArray;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

use function Psy\debug;

class BotController extends Controller{

public function index(Request $request) {
    $telegram=app(Telegram::class); 
    $messageFromUser= $request->input('message')['text'];
    $telegramUserId=$request->input('message.from')['id'];

    //Log::debug($request->input('message')['text']);
    if ($messageFromUser == "/start"){
    $sendMessage = $telegram -> sendMessage($telegramUserId, 'Здарова');
    } else {
    $sendMessage = $telegram -> sendMessage($telegramUserId, 'Ну что тебе нужно');
    }

    
    // $public = $request->input('');
    // $request=json_decode($request, true);
    // $requestt=$request["0"];
    // Log::debug($requestt);
    

    // $public = $request[0];
    // $telegram=app(Telegram::class);   
    // $sendMessage = $telegram -> sendMessage(902325136, $public);
    // $sendMessage = json_decode($sendMessage);
    // dd($sendMessage);
}
}



