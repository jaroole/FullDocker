<?php

namespace App\Console\Commands;

use App\Telegram\Telegram;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class openQuestionCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'open:question';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Open Question command';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()

    {

        $telegram = app(Telegram::class);
        $question = $telegram->makeQuestion();
        //$thanksButtons = $telegram->sendThanksButtons();
        $telega_users = DB::table('telega_users')->pluck('userId');
        foreach ($telega_users as $telegramUserId) {
            if (DB::table('telega_users')->where('userId',$telegramUserId)->value('active')==false ){
                $telegram->sendQuestion($telegramUserId, $question);
            }
            
        }
        return 0;
    }
}
