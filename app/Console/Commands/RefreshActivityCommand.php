<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class RefreshActivityCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'refresh:activity';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Refresh users activity';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()

    {
        DB::table('telega_users')->update(array('active' => 0));

        return 0;
    }
}
