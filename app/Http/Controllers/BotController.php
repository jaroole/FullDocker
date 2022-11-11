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

use function PHPUnit\Framework\callback;
use function Psy\debug;

class BotController extends Controller
{

    public function index(Request $request)
    {
        Log::debug($request->all());
        $telegram = app(Telegram::class);
        $mainButtons = $telegram->sendMainButtons();
        $accauntButtons = $telegram->sendAccauntButtons();
        $registerButtons = $telegram->sendRegisterButtons();
        $thanksButtons = $telegram->sendThanksButtons();

        if (isset($request->input('message')['text']) and isset($request->input('message.reply_to_message')['text'])) {
            $messageFromUser = $request->input('message')['text'];
            $telegramUserId = $request->input('message.from')['id'];
            $userName = DB::table('telega_users')->where('userId', $telegramUserId)->value('name');
            $userTeam = DB::table('telega_users')->where('userId', $telegramUserId)->value('team');
            $userJobTitle = DB::table('telega_users')->where('userId', $telegramUserId)->value('jobTitle');
            $userGrade = DB::table('telega_users')->where('userId', $telegramUserId)->value('grade');



            if ($request->input('message.reply_to_message')['text'] == "Put your Name:") {
                DB::table('telega_users')->where('userid', $telegramUserId)->update(array('name' => $messageFromUser));
                $messageForRegister = "<b>Your accaunt data:</b> \n\n<b>Name:</b> $messageFromUser \n<b>Team:</b> $userTeam \n<b>JobTitle:</b> $userJobTitle \n<b>Grade:</b> $userGrade \n";
                $telegram->sendButtons($telegramUserId, $messageForRegister, json_encode($registerButtons));
            } elseif ($request->input('message.reply_to_message')['text'] == "Put your Team:") {
                DB::table('telega_users')->where('userid', $telegramUserId)->update(array('team' => $messageFromUser));
                $messageForRegister = "<b>Your accaunt data:</b> \n\n<b>Name:</b> $userName \n<b>Team:</b> $messageFromUser \n<b>JobTitle:</b> $userJobTitle \n<b>Grade:</b> $userGrade \n";
                $telegram->sendButtons($telegramUserId, $messageForRegister, json_encode($registerButtons));
            } elseif ($request->input('message.reply_to_message')['text'] == "Put your Job Title:") {
                DB::table('telega_users')->where('userid', $telegramUserId)->update(array('jobTitle' => $messageFromUser));
                $messageForRegister = "<b>Your accaunt data:</b> \n\n<b>Name:</b> $userName \n<b>Team:</b> $userTeam \n<b>JobTitle:</b> $messageFromUser \n<b>Grade:</b> $userGrade \n";
                $telegram->sendButtons($telegramUserId, $messageForRegister, json_encode($registerButtons));
            } elseif ($request->input('message.reply_to_message')['text'] == "Put your Grade:") {
                DB::table('telega_users')->where('userid', $telegramUserId)->update(array('grade' => $messageFromUser));
                $messageForRegister = "<b>Your accaunt data:</b> \n\n<b>Name:</b> $userName \n<b>Team:</b> $userTeam \n<b>JobTitle:</b> $userJobTitle \n<b>Grade:</b> $messageFromUser \n";
                $telegram->sendButtons($telegramUserId, $messageForRegister, json_encode($registerButtons));
            }
        } elseif (isset($request->input('message')['text'])) {
            $telegramUserId = $request->input('message.from')['id'];
            $messageFromUser = $request->input('message')['text'];

            if ($messageFromUser == "/start") {
                $telegram->sendMessage($telegramUserId, 'Wellcome!');
                $telegram->sendButtons($telegramUserId, 'Main menu:', json_encode($mainButtons));
                if (DB::table('telega_users')->where('userId', $telegramUserId)->value('userId')==false){
                DB::insert('insert into telega_users (userId) values (?)', [$telegramUserId]);
                }
            } else {
                $telegram->sendMessage($telegramUserId, 'I can not recognize it, choose here please: /start');
            }
        }
    





        if (isset($request->input('callback_query')['data'])) {
            $callBackFromUser = $request->input('callback_query')['data'];
            $telegramUserId = $request->input('callback_query.from')['id'];


            if ($callBackFromUser == "1") {
                $userName = DB::table('telega_users')->where('userId', $telegramUserId)->value('name');
                $userTeam = DB::table('telega_users')->where('userId', $telegramUserId)->value('team');
                $userJobTitle = DB::table('telega_users')->where('userId', $telegramUserId)->value('jobTitle');
                $userGrade = DB::table('telega_users')->where('userId', $telegramUserId)->value('grade');
                $messageForRegister = "<b>Your accaunt data:</b> \n\n<b>Name:</b> $userName \n<b>Team:</b> $userTeam \n<b>JobTitle:</b> $userJobTitle \n<b>Grade:</b> $userGrade \n";                
                $telegram->sendButtons($telegramUserId, $messageForRegister, json_encode($registerButtons));

            }elseif($callBackFromUser == "3"){
                $telegram->sendButtons($telegramUserId, "Say thanks or dont", json_encode($thanksButtons));
            

            } elseif ($callBackFromUser == "toMainMenu") {
                $telegram->sendButtons($telegramUserId, 'Main menu:', json_encode($mainButtons));
            } elseif ($callBackFromUser == "11") {
                $telegram->sendButtonsWithQuery($telegramUserId, 'Put your Name:');
            } elseif ($callBackFromUser == "12") {
                $telegram->sendButtonsWithQuery($telegramUserId, 'Put your Team:');
            } elseif ($callBackFromUser == "13") {
                $telegram->sendButtonsWithQuery($telegramUserId, 'Put your Job Title:');
            } elseif ($callBackFromUser == "14") {
                $telegram->sendButtonsWithQuery($telegramUserId, "Put your Grade: ");
            }
           
        }
        //$telegram->sendButtons($telegramUserId, 'Main menu:', json_encode($mainButtons))->everyMinute();
        //$telegram->sendMessage($telegramUserId, 'это ежедневное сообщение')->dailyAt('12:15');
        //date('Y-m-d H:i:s')
    }
}
