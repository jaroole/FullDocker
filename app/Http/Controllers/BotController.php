<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;

class BotController extends Controller{

    public function __construct()
    {
        
    }

    public function bot(){
        
            \Illuminate\Support\Facades\Http::post('https://api.tlgr.org/bot5620620072:AAGriRMadgmzXSg3FKpB8psK9caN-HqBAP0/sendMessage', [
                'chat_id'=> 902325136,
                'text' => 'Hellow from API!!',
                'perse_mode'=> 'html',
            ]);
    }
    
    
}



