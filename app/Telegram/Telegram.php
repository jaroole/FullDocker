<?php
namespace App\Telegram;

use Illuminate\Support\Facades\Http;



class Telegram {


        protected $http;
        public function __construct(Http $http)
        {
            $this->http = $http;
        }

        public function sendMessage($chat_id, $message){

            $this->http::post('https://api.tlgr.org/bot5620620072:AAGriRMadgmzXSg3FKpB8psK9caN-HqBAP0/sendMessage', [
                'chat_id'=> $chat_id,
                'text' => $message,
                'parse_mode' => 'html',
            ]);
        }

}

//902325136