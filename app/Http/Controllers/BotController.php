<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Telegram\Telegram;
use Hamcrest\Arrays\IsArray;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use PhpParser\Node\Stmt\ElseIf_;

use function Psy\debug;

class BotController extends Controller
{

    public function index(Request $request)
    {
        Log::debug($request->all());
        $telegram = app(Telegram::class);

        if (isset($request->input('message')['text'])) {
            $messageFromUser = $request->input('message')['text'];
            $telegramUserId = $request->input('message.from')['id'];

            if ($messageFromUser == "/start") {
                $sendMessage = $telegram->sendMessage($telegramUserId, 'Бот приветсвует тебя');
                $buttons = [
                    'inline_keyboard' => [
                        [
                            [
                                'text' => 'Регистрация',
                                'callback_data' => '1',

                            ],

                        ],

                        [
                            [
                                'text' => 'Настройка аккаунта',
                                'callback_data' => '2',

                            ],

                        ],
                        [
                            [
                                'text' => 'Сказать спасибо',
                                'callback_data' => '3',

                            ],

                        ],

                        [
                            [
                                'text' => 'Кому не скажу спасибо',
                                'callback_data' => '4',

                            ],

                        ],

                    ]
                ];
                $telegram->sendButtons($telegramUserId, 'Вот что я могу:', json_encode($buttons));
            } elseif(str_contains($messageFromUser, "/name")){
            $telegram->sendMessage($telegramUserId, $messageFromUser);
            $name=str_replace("/name ", "", $messageFromUser);
            DB::insert('insert into telega_users (name) values (?)', [$name]);
            }
            else {
                $telegram->sendMessage($telegramUserId, 'Я вас не понимаю, для вызова меню нажмите на: /start');
            }
        }

        if (isset($request->input('callback_query')['data'])) {
            $callBackFromUser = $request->input('callback_query')['data'];
            $telegramUserId = $request->input('callback_query.from')['id'];
            if ($callBackFromUser == "1") {
                $telegram->sendMessage($telegramUserId, 'Введите свои данные /name, /team, /jobTitle, /grade. Пример: /name Алексей');
                
            }
        }
        
    }
}

