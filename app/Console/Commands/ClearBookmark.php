<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;


class ClearBookmark extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bookmark:clear';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'To clear bookmark data';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        DB::table('bookmarks')->where('created_at', '>=', Carbon::now()->subDay()->toDateTimeString())->delete();
    }
}
