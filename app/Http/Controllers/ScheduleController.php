<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\Facades\DB;
use App\Telegram\Telegram;

class ScheduleController extends Controller
{
    
    protected function schedule(Schedule $schedule)
    {
        
            $schedule->call(function () {
            $telegram = app(Telegram::class);
            $telegramUserId = DB::table('telega_users')->first()->value('userId');
            $telegram->sendMessage($telegramUserId, 'I can not recognize it, choose here please: /start')->everyMinute();});
            
    }
}
