<?php

namespace App\Jobs;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class DeleteTempFiles implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $files = collect(Storage::disk(getDisk())->files('temp'));
        $files = $files->filter(function ($file) {
            if (Carbon::parse(Storage::disk(getDisk())->lastModified($file))->lessThan(Carbon::now()->subDay()))
                return true;
            return false;
        });
        Storage::disk(getDisk())->delete($files->toArray());
    }
}
