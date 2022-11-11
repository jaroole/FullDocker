<?php

namespace App\Console\Commands;

use App\Telegram\Telegram;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class sayThanksCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'say:thanks';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'SayThanksTo';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $telegram = app(Telegram::class);
        $thanksButtons = $telegram->sendThanksButtons();
        $telega_users = DB::table('telega_users')->pluck('userId');
        foreach ($telega_users as $telegramUserId){
            
        $telegram->sendButtons($telegramUserId, "Say thanks or dont", json_encode($thanksButtons));
        
        }
        return 0;
        
    }
}
