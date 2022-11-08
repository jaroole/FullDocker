<?php
namespace App\Telegram;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class Telegram {


        protected $http;
        //protected $bot;
        const url = 'https://api.tlgr.org/bot';
        
        public function bot(){
            return config('bots.bot');
        }
        
        public function __construct(Http $http) #какая то хуйня с переменной бот из аппсервиспровайдера
        {
            $this->http = $http;
            
        }

        public function sendMessage($chat_id, $message){

        return    $this->http::post(self::url.$this->bot().'/sendMessage', [
                'chat_id'=> $chat_id,
                'text' => $message,
                'parse_mode' => 'html',
            ]);
        }


        public function sendDocument($chat_id, $file){

        return    $this->http::attach('document', Storage::get('/public/hi.png'),'document.png')->post(self::url.$this->bot().'/sendDocument', [
                'chat_id'=> $chat_id,


            ]);
        }

        public function sendButtons($chat_id, $message, $button){

            return    $this->http::post(self::url.$this->bot().'/sendMessage', [
                    'chat_id'=> $chat_id,
                    'text' => $message,
                    'parse_mode' => 'html',
                    'reply_markup' => $button,
                ]);
            }


}

