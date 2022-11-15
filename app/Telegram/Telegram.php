<?php

namespace App\Telegram;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class Telegram
{


    protected $http;
    //protected $bot;
    const url = 'https://api.tlgr.org/bot';

    public function bot()
    {
        return config('bots.bot');
    }

    public function __construct(Http $http) #какая то хуйня с переменной бот из аппсервиспровайдера
    {
        $this->http = $http;
    }

    public function sendMessage($chat_id, $message)
    {

        return    $this->http::post(self::url . $this->bot() . '/sendMessage', [
            'chat_id' => $chat_id,
            'text' => $message,
            'parse_mode' => 'html',
        ]);
    }


    public function sendDocument($chat_id, $file)
    {

        return    $this->http::attach('document', Storage::get('/public/hi.png'), 'document.png')->post(self::url . $this->bot() . '/sendDocument', [
            'chat_id' => $chat_id,


        ]);
    }

    public function sendButtons($chat_id, $message, $button)
    {

        return    $this->http::post(self::url . $this->bot() . '/sendMessage', [
            'chat_id' => $chat_id,
            'text' => $message,
            'parse_mode' => 'html',
            'reply_markup' => $button,
        ]);
    }
    public function sendButtonsWithQuery($chat_id, $message)
    {

        return    $this->http::post(self::url . $this->bot() . '/sendMessage', [
            'chat_id' => $chat_id,
            'text' => $message,
            'parse_mode' => 'html',
            'reply_markup' => json_encode(['force_reply' => true, 'selective' => false]),
        ]);
    }


    public function sendMainButtons()
    {
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

                // [
                //     [
                //         'text' => 'Your labor costs',
                //         'callback_data' => '4',

                //     ],

                // ],

            ]
        ];
    }

    public function sendAccauntButtons()
    {
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

    public function sendRegisterButtons()
    {
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

    public function sendThanksButtons()
    {
        return [
            'inline_keyboard' => [
                [
                    [
                        'text' => 'Thanks to your colleague',
                        'callback_data' => 'thanks_jobtitle',

                    ],

                ],

                [
                    [
                        'text' => 'Thanks to someone from your team',
                        'callback_data' => 'thanks_team',

                    ],

                ],
                [
                    [
                        'text' => 'Thanks to experts L+',
                        'callback_data' => 'thanks_expertGrade',

                    ],

                ],

                [
                    [
                        'text' => 'Thanks to new colleagues J, M1, M2',
                        'callback_data' => 'thanks_newGrade',

                    ],

                ],

                [
                    [
                        'text' => 'Thanks to JobTitle with',
                        'callback_data' => 'thanks_diffrentJobTitle',

                    ],

                ],

                [
                    [
                        'text' => 'I do not want to say thanks to',
                        'callback_data' => 'dont_say_thanks',

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

    public function makeButtons($name, $callBack)
    {
        return [
            'inline_keyboard' => [
                [
                    [
                        'text' => $name,
                        'callback_data' => $callBack,

                    ],

                ],

            ]
        ];
    }

    public function makeManyButtons($telegramUserId)
    {
        $i = 0;

        foreach ($telegramUserId as $value) {


            $buttons[$i][0] = [
                'text' => DB::table('telega_users')->where('userId', $value)->value('name'),
                'callback_data' => DB::table('telega_users')->where('userId', $value)->value('userId')
            ];
            $i++;
        }
        return ['inline_keyboard' => $buttons];
    }

    public function makeDontSayThanksButtons($telegramUserId, $SecondParameter, $textonButton)
    {
        $i = 0;

        foreach ($telegramUserId as $value) {


            $buttons[$i][0] = [
                'text' => DB::table('telega_users')->where($SecondParameter, $value)->value($textonButton),
                'callback_data' => 'dont_thanks' . $SecondParameter . DB::table('telega_users')->where($SecondParameter, $value)->value($SecondParameter)
            ];
            $i++;
        }
        return ['inline_keyboard' => $buttons];
    }

    public function tableSortBy($query)
    {

        $sortBy = DB::table('telega_users')->pluck($query);
        $sortBy = json_decode($sortBy);
        $sortBy = array_values(array_unique($sortBy));
        $sortBy = $sortBy[array_rand($sortBy, 1)];

        return $sortBy;
    }

    public function tableSortAll($query)
    {

        $sortBy = DB::table('telega_users')->pluck($query);
        $sortBy = json_decode($sortBy);
        $sortBy = array_values(array_unique($sortBy));


        return $sortBy;
    }

    public function makeQuestion()
    {

        $questions = file("/var/www/storage/Questions.txt");
        foreach ($questions as $value) {
            if (DB::table('list_of_questions')->where('question', $value)->value('question') == false) {
                DB::insert('insert into list_of_questions (question) values (?)', [$value]);
            }

            $question = DB::table('list_of_questions')->inRandomOrder()->value('question');
        }
        return $question;
    }

    public function takeQuestion()
    {

        $questions = file("/var/www/storage/Questions.txt");

        return $questions;
    }




    public function sendQuestion($chat_id, $message)
    {

        return    $this->http::post(self::url . $this->bot() . '/sendMessage', [
            'chat_id' => $chat_id,
            'text' => $message,
            'parse_mode' => 'html',
            'reply_markup' => json_encode(['force_reply' => true, 'selective' => false]),
        ]);
    }



}
