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
        public function sendButtonsWithQuery($chat_id, $message){

                return    $this->http::post(self::url.$this->bot().'/sendMessage', [
                        'chat_id'=> $chat_id,
                        'text' => $message,
                        'parse_mode' => 'html',
                        'reply_markup' => json_encode(['force_reply' => true,'selective' => false]),
                    ]);
                }

        
        public function sendMainButtons(){
            return [
                'inline_keyboard' => [
                    [
                        [
                            'text' => 'Accaunt data',
                            'callback_data' => '1',

                        ],

                    ],

                    // [
                    //     [
                    //         'text' => 'Account settings',
                    //         'callback_data' => '2',

                    //     ],

                    // ],
                    [
                        [
                            'text' => 'Say thanks to ...',
                            'callback_data' => '3',

                        ],

                    ],

                    [
                        [
                            'text' => 'Your labor costs',
                            'callback_data' => '4',

                        ],

                    ],

                ]
            ];
        }

        public function sendAccauntButtons(){
            return [
                'inline_keyboard' => [
                    [
                        [
                            'text' => 'Change Name',
                            'callback_data' => '21',

                        ],
                        [
                            'text' => 'Change Team',
                            'callback_data' => '22',

                        ],

                    ],

                    [
                        [
                            'text' => 'Change JobTitle',
                            'callback_data' => '23',

                        ],
                        [
                            'text' => 'Change Grade',
                            'callback_data' => '24',

                        ],

                    ],
                    [
                        [
                            'text' => '<<<===Go back to menu',
                            'callback_data' => 'toMainMenu',

                        ],

                    ],

                ]
            ];
        }

        public function sendRegisterButtons(){
            return [
                'inline_keyboard' => [
                    [
                        [
                            'text' => 'Put your Name:',
                            'callback_data' => '11',

                        ],
                        [
                            'text' => 'Put your Team:',
                            'callback_data' => '12',

                        ],

                    ],

                    [
                        [
                            'text' => 'Put your Job Title:',
                            'callback_data' => '13',

                        ],
                        [
                            'text' => 'Put your Grade:',
                            'callback_data' => '14',

                        ],

                    ],
                    [
                        [
                            'text' => '<<<===Go back to menu',
                            'callback_data' => 'toMainMenu',

                        ],

                    ],

                ]
            ];
        }
       
        public function sendThanksButtons(){
            return [
                'inline_keyboard' => [
                    [
                        [
                            'text' => 'Thanks to colleagues',
                            'callback_data' => 'thanks_1',

                        ],

                    ],

                    [
                        [
                            'text' => 'Thanks to team',
                            'callback_data' => 'thanks_2',

                        ],

                    ],
                    [
                        [
                            'text' => 'Thanks to L+',
                            'callback_data' => 'thanks_3',

                        ],

                    ],

                    [
                        [
                            'text' => 'Thanks to J, M1, M2',
                            'callback_data' => 'thanks_4',

                        ],

                    ],

                    [
                        [
                            'text' => 'Thanks to JobTitle with',
                            'callback_data' => 'thanks_5',

                        ],

                    ],

                    [
                        [
                            'text' => 'Don not say thanks to',
                            'callback_data' => 'thanks_6',

                        ],

                    ],
                    [
                        [
                            'text' => '<<<===Go back to menu',
                            'callback_data' => 'toMainMenu',

                        ],

                    ],

                ]
            ];
        }
}



