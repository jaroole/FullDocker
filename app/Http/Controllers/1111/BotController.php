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
            } elseif (str_contains($messageFromUser, "/name" )) {
                if ($telegramUserId != DB::table('telega_users')->where('userId', $telegramUserId)->value('userId'))
                
                {
                    $name = str_replace("/name ", "", $messageFromUser);
                    DB::insert('insert into telega_users (name, userId) values (?, ?)', [$name, $telegramUserId]);
                    $telegram->sendMessage($telegramUserId, "Ваше имя: $messageFromUser");
                    



                } else {
                    $userName = DB::table('telega_users')->where('userId', $telegramUserId)->value('name');
                    $telegram->sendMessage($telegramUserId, "Вы уже зарегестрированы как $userName");
                }
            } else {
                $telegram->sendMessage($telegramUserId, 'Я вас не понимаю, для вызова меню нажмите на: /start');
            }
        }






        if (isset($request->input('callback_query')['data'])) {
            $callBackFromUser = $request->input('callback_query')['data'];
            $telegramUserId = $request->input('callback_query.from')['id'];
            
            if ($callBackFromUser == "1" and $telegramUserId != DB::table('telega_users')->where('userId', $telegramUserId)->value('userId')) {
                $telegram->sendMessage($telegramUserId, 'Чтобы зарегестрироваться, необходимо последовательно отправить свои данные, /name, /team, /jobTitle, /grade
                Ввод каждого из параметров необходимо вводить с командой начиная с "/". Пример: /name Алексей');
            
            } elseif ($callBackFromUser == "1" and $telegramUserId = DB::table('telega_users')->where('userId', $telegramUserId)->value('userId')) {
                $userName = DB::table('telega_users')->where('userId', $telegramUserId)->value('name');
                $telegram->sendMessage($telegramUserId, "Вы уже зарегестрированы как $userName");
            
            } elseif ($callBackFromUser == "2" and $telegramUserId != DB::table('telega_users')->where('userId', $telegramUserId)->value('userId')) {
                $telegram->sendMessage($telegramUserId, 'Вы не зарегестрированы');
            
            } elseif ($callBackFromUser == "2" and $telegramUserId = DB::table('telega_users')->where('userId', $telegramUserId)->value('userId')) {
                $userName = DB::table('telega_users')->where('userId', $telegramUserId)->value('name');
                $userTeam = DB::table('telega_users')->where('userId', $telegramUserId)->value('team');
                $userJobTitle = DB::table('telega_users')->where('userId', $telegramUserId)->value('jobTitle');
                $userGrade = DB::table('telega_users')->where('userId', $telegramUserId)->value('grade');
                $telegram->sendMessage($telegramUserId, "Ваши учетные данные: \nName: $userName \nTeam: $userTeam \nJobTitle: $userJobTitle \nGrade: $userGrade \n");
                
                $buttons = [
                    'inline_keyboard' => [
                        [
                            [
                                'text' => 'Изменить Name',
                                'callback_data' => '21',

                            ],

                        ],

                        [
                            [
                                'text' => 'Изменить Team',
                                'callback_data' => '22',

                            ],

                        ],
                        [
                            [
                                'text' => 'Изменить JobTitle',
                                'callback_data' => '23',

                            ],

                        ],

                        [
                            [
                                'text' => 'Изменить Grade',
                                'callback_data' => '24',

                            ],

                        ],
                        [
                            [
                                'text' => '<<<===Вернуться в меню',
                                'callback_data' => '25',

                            ],

                        ],

                    ]
                ];
                $telegram->sendButtons($telegramUserId, 'Изменить:', json_encode($buttons));
            }
        }
    }
}
