<?php

namespace App\Console;

use App\Telegram\Telegram;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\DB;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */

    protected function schedule(Schedule $schedule)
    {
        //$schedule->command('open:question')->everyMinute()->withoutOverlapping();
        $schedule->command('say:thanks')->dailyAt('12:00')->withoutOverlapping();
        $schedule->command('refresh:activity')->dailyAt('18:00')->withoutOverlapping();

        if (DB::table('week')->where('id', 1)->value('week') == false) {
            DB::insert('insert into week (week) values (?)', [1]);
        }

        if (DB::table('week')->where('id', 1)->value('week') == 1){
            $schedule->command('open:question')->weeklyOn(1, '9:00')->hourly()->withoutOverlapping();
        }
        if (DB::table('week')->where('id', 1)->value('week') == 2){
            $schedule->command('open:question')->weeklyOn(2, '9:00')->hourly()->withoutOverlapping();
        }

        if (DB::table('week')->where('id', 1)->value('week') == 1){
        $schedule->command('open:question')->weeklyOn(4, '9:00')->hourly()->withoutOverlapping();
        DB::table('week')->where('id', 1)->update(array('week' => 2));


        }elseif (DB::table('week')->where('id', 1)->value('week') == 2){
            $schedule->command('open:question')->weeklyOn(5, '9:00')->hourly()->withoutOverlapping();
            DB::table('week')->where('id', 1)->update(array('week' => 1));
            }

        

    }


    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
