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
use Illuminate\Console\Scheduling\Schedule;
use App\Jobs\Heartbeat;
use League\CommonMark\Node\Query\AndExpr;

use function PHPUnit\Framework\callback;
use function Psy\debug;

class BotController extends Controller
{

    public function index(Request $request)
    {
        Log::debug($request->all());
        $telegram = app(Telegram::class);
        
        $accountButtons = $telegram->sendAccountButtons();
        $registerButtons = $telegram->sendRegisterButtons();
        $thanksButtons = $telegram->sendThanksButtons();

        if (isset($request->input('message')['text']) and isset($request->input('message.reply_to_message')['text'])) {
            $messageFromUser = strtoupper($request->input('message')['text']);
            $telegramUserId = $request->input('message.from')['id'];
            $userName = DB::table('telega_users')->where('userId', $telegramUserId)->value('name');
            $userTeam = DB::table('telega_users')->where('userId', $telegramUserId)->value('team');
            $userJobTitle = DB::table('telega_users')->where('userId', $telegramUserId)->value('jobTitle');
            $userGrade = DB::table('telega_users')->where('userId', $telegramUserId)->value('grade');
            $mainButtons = $telegram->sendMainButtons($telegramUserId);



            if ($request->input('message.reply_to_message')['text'] == "Put your Name:") {
                DB::table('telega_users')->where('userid', $telegramUserId)->update(array('name' => $messageFromUser));
                $messageForRegister = "<b>Your account data:</b> \n\n<b>Name:</b> $messageFromUser \n<b>Team:</b> $userTeam \n<b>JobTitle:</b> $userJobTitle \n<b>Grade:</b> $userGrade \n";
                $telegram->sendButtons($telegramUserId, $messageForRegister, json_encode($registerButtons));
            } elseif ($request->input('message.reply_to_message')['text'] == "Put your Team:") {
                if (DB::table('telega_users')->where('userId', $telegramUserId)->value('userId') == false) {

                }
                DB::table('telega_users')->where('userid', $telegramUserId)->update(array('team' => $messageFromUser));
                $messageForRegister = "<b>Your account data:</b> \n\n<b>Name:</b> $userName \n<b>Team:</b> $messageFromUser \n<b>JobTitle:</b> $userJobTitle \n<b>Grade:</b> $userGrade \n";
                $telegram->sendButtons($telegramUserId, $messageForRegister, json_encode($registerButtons));
            } elseif ($request->input('message.reply_to_message')['text'] == "Put your Job Title:") {
                DB::table('telega_users')->where('userid', $telegramUserId)->update(array('jobTitle' => $messageFromUser));
                $messageForRegister = "<b>Your accaont data:</b> \n\n<b>Name:</b> $userName \n<b>Team:</b> $userTeam \n<b>JobTitle:</b> $messageFromUser \n<b>Grade:</b> $userGrade \n";
                $telegram->sendButtons($telegramUserId, $messageForRegister, json_encode($registerButtons));
            } elseif ($request->input('message.reply_to_message')['text'] == "Put your Grade:") {
                DB::table('telega_users')->where('userid', $telegramUserId)->update(array('grade' => $messageFromUser));
                $messageForRegister = "<b>Your account data:</b> \n\n<b>Name:</b> $userName \n<b>Team:</b> $userTeam \n<b>JobTitle:</b> $userJobTitle \n<b>Grade:</b> $messageFromUser \n";
                $telegram->sendButtons($telegramUserId, $messageForRegister, json_encode($registerButtons));
           
            } elseif (str_contains($request->input('message.reply_to_message')['text'], 'Question!')) {

                $telegram->sendMessage($telegramUserId, 'Thanks for your answer!');
                DB::table('telega_users')->where('userid', $telegramUserId)->update(array('question' => $request->input('message.reply_to_message')['text']));
                DB::table('telega_users')->where('userid', $telegramUserId)->update(array('answer' => $messageFromUser));
                DB::table('telega_users')->where('userid', $telegramUserId)->update(array('active' => 1));
                DB::table('telega_users')->where('userid', $telegramUserId)->update(array('answerDate' => date('Y-m-d H:i:s'))); 
            }

        } elseif (isset($request->input('message')['text'])) {
            $telegramUserId = $request->input('message.from')['id'];
            $messageFromUser = $request->input('message')['text'];
            $userName = DB::table('telega_users')->where('userId', $telegramUserId)->value('name');
            $userTeam = DB::table('telega_users')->where('userId', $telegramUserId)->value('team');
            $userJobTitle = DB::table('telega_users')->where('userId', $telegramUserId)->value('jobTitle');
            $userGrade = DB::table('telega_users')->where('userId', $telegramUserId)->value('grade');
            $mainButtons = $telegram->sendMainButtons($telegramUserId);
            if ($messageFromUser == "/start") {
                $telegram->sendMessage($telegramUserId, 'Wellcome!');
                $telegram->sendButtons($telegramUserId, 'Main menu:', json_encode($mainButtons));
                if (DB::table('telega_users')->where('userId', $telegramUserId)->value('userId') == false) {
                    DB::insert('insert into telega_users (userId) values (?)', [$telegramUserId]);
                    DB::table('telega_users')->where('userId', $telegramUserId)->update(array('question' => ""));
                    
                }


 ##Ввод персональных данных       
        }elseif (DB::table('telega_users')->where('userId', $telegramUserId)->value('question') == "name") {
                DB::table('telega_users')->where('userId', $telegramUserId)->update(array('name' => $messageFromUser));
                DB::table('telega_users')->where('userId', $telegramUserId)->update(array('question' => ""));
                $messageForRegister = "<b>Your account data:</b> \n\n<b>Name:</b> $messageFromUser \n<b>Team:</b> $userTeam \n<b>JobTitle:</b> $userJobTitle \n<b>Grade:</b> $userGrade \n";
                $telegram->sendButtons($telegramUserId, $messageForRegister, json_encode($registerButtons));
        }elseif (DB::table('telega_users')->where('userId', $telegramUserId)->value('question') == "team") {
                DB::table('telega_users')->where('userId', $telegramUserId)->update(array('team' => $messageFromUser));
                DB::table('telega_users')->where('userId', $telegramUserId)->update(array('question' => ""));
                $messageForRegister = "<b>Your account data:</b> \n\n<b>Name:</b> $userName \n<b>Team:</b> $messageFromUser \n<b>JobTitle:</b> $userJobTitle \n<b>Grade:</b> $userGrade \n";
                $telegram->sendButtons($telegramUserId, $messageForRegister, json_encode($registerButtons));
               
        }elseif (DB::table('telega_users')->where('userId', $telegramUserId)->value('question') == "jobTitle") {
            DB::table('telega_users')->where('userId', $telegramUserId)->update(array('jobTitle' => $messageFromUser));
            DB::table('telega_users')->where('userId', $telegramUserId)->update(array('question' => ""));
            $messageForRegister = "<b>Your account data:</b> \n\n<b>Name:</b> $userName \n<b>Team:</b> $userTeam \n<b>JobTitle:</b> $messageFromUser \n<b>Grade:</b> $userGrade \n";
            $telegram->sendButtons($telegramUserId, $messageForRegister, json_encode($registerButtons));
           
        }elseif (DB::table('telega_users')->where('userId', $telegramUserId)->value('question') == "grade") {
            DB::table('telega_users')->where('userId', $telegramUserId)->update(array('grade' => $messageFromUser));
            DB::table('telega_users')->where('userId', $telegramUserId)->update(array('question' => ""));
            $messageForRegister = "<b>Your account data:</b> \n\n<b>Name:</b> $userName \n<b>Team:</b> $userTeam \n<b>JobTitle:</b> $userJobTitle \n<b>Grade:</b> $messageFromUser \n";
            $telegram->sendButtons($telegramUserId, $messageForRegister, json_encode($registerButtons));
####        
                




                
        }else {
                $telegram->sendMessage($telegramUserId, 'I can not recognize it, choose here please: /start');
                DB::table('telega_users')->where('userId', $telegramUserId)->update(array('question' => ""));

                #Тестирование. Установка не активного юзера 
                // $telegram->sendMessage($telegramUserId, DB::table('week')->where('id', 1)->value('week'));
                // $telegram->sendMessage($telegramUserId, DB::table('telega_users')->where('userid', $telegramUserId)->value('active'));
                // DB::table('telega_users')->where('userid', $telegramUserId)->update(array('active' => 0));
                // $telegram->sendMessage($telegramUserId, DB::table('telega_users')->where('userid', $telegramUserId)->value('active'));


        }
    }






        if (isset($request->input('callback_query')['data'])) {
            $callBackFromUser = $request->input('callback_query')['data'];
            $telegramUserId = $request->input('callback_query.from')['id'];


            if ($callBackFromUser == "1") {
                if (DB::table('telega_users')->where('userId', $telegramUserId)->value('userId') == false) {
                    DB::insert('insert into telega_users (userId) values (?)', [$telegramUserId]);
                }elseif(DB::table('telega_users')->where('userId', $telegramUserId)->value('registered') == 1){
                $fio = DB::table('telega_users')->where('userId', $telegramUserId)->value('fio');
                $telegram->sendMessage($telegramUserId, "$fio вы уже зарегестрированы!");

                }elseif(DB::table('telega_users')->where('userId', $telegramUserId)->value('registered') == 0){
                $userName = DB::table('telega_users')->where('userId', $telegramUserId)->value('name');
                $userTeam = DB::table('telega_users')->where('userId', $telegramUserId)->value('team');
                $userJobTitle = DB::table('telega_users')->where('userId', $telegramUserId)->value('jobTitle');
                $userGrade = DB::table('telega_users')->where('userId', $telegramUserId)->value('grade');
                $messageForRegister = "<b>Your account data:</b> \n\n<b>Name:</b> $userName \n<b>Team:</b> $userTeam \n<b>JobTitle:</b> $userJobTitle \n<b>Grade:</b> $userGrade \n";
                $telegram->sendButtons($telegramUserId, $messageForRegister, json_encode($registerButtons));
                }

            } elseif ($callBackFromUser == "15") {
               if (DB::table('users')->value('name') == false) {
                    $telegram->usersCreate();
                }
                $telega_users = DB::table('users')->pluck('fio');
                $telegram->sendButtons($telegramUserId, "Для сверки введенных данных выберите себя из списка:", 
                json_encode($telegram->makeButtonsfromMainDB($telega_users, 'fio', 'fio')));

            } elseif ($callBackFromUser == DB::table('users')->where('fio', $callBackFromUser)->value('fio')) {
                
                if (
                    strtoupper(DB::table('users')->where('fio', $callBackFromUser )->value('name')) ==   strtoupper(DB::table('telega_users')->where('userId', $telegramUserId)->value('name')) AND
                    strtoupper(DB::table('users')->where('fio', $callBackFromUser )->value('team')) ==  strtoupper(DB::table('telega_users')->where('userId', $telegramUserId)->value('team')) AND
                    strtoupper(DB::table('users')->where('fio', $callBackFromUser )->value('jobTitle')) ==   strtoupper(DB::table('telega_users')->where('userId', $telegramUserId)->value('jobTitle')) AND
                    strtoupper(DB::table('users')->where('fio', $callBackFromUser )->value('grade') ==  strtoupper(DB::table('telega_users')->where('userId', $telegramUserId)->value('grade'))))
                    {
                        DB::table('telega_users')->where('userId', $telegramUserId)->update(array('registered' => '1'));
                        DB::table('telega_users')->where('userId', $telegramUserId)->update(array('fio' => $callBackFromUser));
                        $fio = DB::table('telega_users')->where('userId', $telegramUserId)->value('fio');
                        //$telegram->sendMessage($telegramUserId, "$fio вы зарегестрированы!");
                        $telegram->sendButtons($telegramUserId, "$fio вы зарегестрированы!", json_encode($telegram->sendbackButton($telegramUserId)));

                    }else{
                        //$telegram->sendMessage($telegramUserId, "Введенные данные не совпадают с выбранным ФИО");
                        $telegram->sendButtons($telegramUserId, "Введенные данные не совпадают с выбранным ФИО, проверьте правильность введенных данных и попробуйте снова", json_encode($telegram->sendRegisterButton($telegramUserId)));
                    }
                
                

            } elseif ($callBackFromUser == "3") {
                $telegram->sendButtons($telegramUserId, "Say thanks ", json_encode($thanksButtons));
                DB::table('telega_users')->where('userId', $telegramUserId)->update(array('question' => ""));
            } elseif ($callBackFromUser == "toMainMenu") {
                $telegram->sendButtons($telegramUserId, 'Main menu:', json_encode($telegram->sendMainButtons($telegramUserId)));
                DB::table('telega_users')->where('userId', $telegramUserId)->update(array('question' => ""));
            } elseif ($callBackFromUser == "11") {
                $telegram->sendButtonsWithQuery($telegramUserId, 'Put your Name:');
                DB::table('telega_users')->where('userId', $telegramUserId)->update(array('question' => 'name'));
            } elseif ($callBackFromUser == "12") {
                $telegram->sendButtonsWithQuery($telegramUserId, 'Put your Team:');
                DB::table('telega_users')->where('userId', $telegramUserId)->update(array('question' => 'team'));
            } elseif ($callBackFromUser == "13") {
                $telegram->sendButtonsWithQuery($telegramUserId, 'Put your Job Title:');
                DB::table('telega_users')->where('userId', $telegramUserId)->update(array('question' => 'jobTitle'));
            } elseif ($callBackFromUser == "14") {
                $telegram->sendButtonsWithQuery($telegramUserId, "Put your Grade: ");
                DB::table('telega_users')->where('userId', $telegramUserId)->update(array('question' => 'grade'));
            } elseif ($callBackFromUser == "thanks_jobtitle") {
                $jobTitle = DB::table('telega_users')->where('userId', $telegramUserId)->value('jobTitle');
                $telega_users = DB::table('telega_users')->where('jobTitle', $jobTitle)->pluck('userId');
                $telegram->sendButtons($telegramUserId, "Choose somebody (Job Title $jobTitle)", json_encode($telegram->makeManyButtons(
                    $telega_users
                )));
            } elseif ($callBackFromUser == "thanks_team") {
                $team = DB::table('telega_users')->where('userId', $telegramUserId)->value('team');
                $telega_users = DB::table('telega_users')->where('team', $team)->pluck('userId');
                $telegram->sendButtons($telegramUserId, "Choose somebody (Team $team)", json_encode($telegram->makeManyButtons(
                    $telega_users
                )));
            } elseif ($callBackFromUser == "thanks_expertGrade") {
                $expertGrades = ['LEAD', 'SENIOR', 'L+'];
                $telega_users = DB::table('telega_users')->whereIn('grade', $expertGrades)->pluck('userId');
                $expertGrades = implode(", ", $expertGrades);
                if (empty($telega_users[0]) == false) {
                    $telegram->sendButtons($telegramUserId, "Choose somebody (Grades $expertGrades)", json_encode($telegram->makeManyButtons(
                        $telega_users
                    )));
                } else {
                    $telegram->sendMessage($telegramUserId, 'Коллеги с данными параметрами не найдены');
                }
                
            } elseif ($callBackFromUser == "thanks_newGrade") {
                $newGrades = ['JUNIOR', 'MIDDLE', 'MIDDLE1', 'MIDDLE2'];
                $telega_users = DB::table('telega_users')->whereIn('grade', $newGrades)->pluck('userId');
                $newGrades = implode(", ", $newGrades);
                if (empty($telega_users[0]) == false) {
                    $telegram->sendButtons($telegramUserId, "Choose somebody (Grades $newGrades)", json_encode($telegram->makeManyButtons(
                        $telega_users
                    )));
                } else {
                    $telegram->sendMessage($telegramUserId, 'Nobody with this parameter');
                }


            } elseif ($callBackFromUser == "thanks_diffrentJobTitle") {
                $jobTitle = $telegram->tableSortBy('jobTitle');
                $telega_users = DB::table('telega_users')->where('jobTitle', $jobTitle)->pluck('userId');
                $telegram->sendButtons($telegramUserId, "Setted random Job Title $jobTitle. Choose somebody for say thanks", json_encode($telegram->makeManyButtons(
                    $telega_users
                )));

                

###
            } elseif ($callBackFromUser == "dont_say_thanks") {
                $teams = $telegram->tableSortAll('team');
                $telegram->sendButtons($telegramUserId, "Choose team: ", json_encode($telegram->makeDontSayThanksButtons(
                    $teams,
                    'team',
                    'team'
                )));
###



            } elseif (str_contains($callBackFromUser, 'dont_thanksteam')) {
                $team = str_replace('dont_thanksteam', "", $callBackFromUser);
                $telega_users = DB::table('telega_users')->where('team', $team)->pluck('userId');
                $telegram->sendButtons($telegramUserId, "I DON'T want to say thanks to: ", json_encode($telegram->makeDontSayThanksButtons(
                    $telega_users,
                    'userId',
                    'name'
                )));


            } elseif (str_contains($callBackFromUser, "dont_thanksuserId")) {
                $callBackFromUser = str_replace('dont_thanksuserId', "", $callBackFromUser);
                $telega_users = DB::table('telega_users')->where('userId', $callBackFromUser)->pluck('userId');

                $nameOfDontThanksGiver = DB::table('telega_users')->where('userId', $telegramUserId)->value('name');
                $teamOfDontThanksGiver = DB::table('telega_users')->where('userId', $telegramUserId)->value('team');

                $nameOfDontThanksTaker = DB::table('telega_users')->where('userId', $callBackFromUser)->value('name');
                $teamOfDontThanksTaker = DB::table('telega_users')->where('userId', $callBackFromUser)->value('team');


                $telegram->sendMessage($callBackFromUser, "$nameOfDontThanksGiver from $teamOfDontThanksGiver team do not want to say thanks to you!");
                $telegram->sendMessage($telegramUserId, "You did not said thanks to $nameOfDontThanksTaker of $teamOfDontThanksTaker team!");
                $telegram->sendMessage($telegramUserId, "And don't remember fill in your labor costs! Thank you!");

           
           
            } elseif ($callBackFromUser == DB::table('telega_users')->where('userId', $callBackFromUser)->value('userId')) {
                $nameOfthanksGiver = DB::table('telega_users')->where('userId', $telegramUserId)->value('name');
                $teamOfthanksGiver = DB::table('telega_users')->where('userId', $telegramUserId)->value('team');

                $nameOfthanksTaker = DB::table('telega_users')->where('userId', $callBackFromUser)->value('name');
                $teamOfthanksTaker = DB::table('telega_users')->where('userId', $callBackFromUser)->value('team');

                $telegram->sendMessage($callBackFromUser, "Thanks to you from $nameOfthanksGiver of $teamOfthanksGiver team!");
                $telegram->sendMessage($telegramUserId, "You said thanks to $nameOfthanksTaker of $teamOfthanksTaker team!");
                $telegram->sendMessage($telegramUserId, "And don't remember fill in your labor costs! Thank you!");
            }
        }
        //$telegram->sendButtons($telegramUserId, 'Main menu:', json_encode($mainButtons))->everyMinute();
        //$telegram->sendMessage($telegramUserId, 'это ежедневное сообщение')->dailyAt('12:15');
        //date('Y-m-d H:i:s')
    }
}
