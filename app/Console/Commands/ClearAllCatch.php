<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class ClearAllCatch extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'clear:all';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear all type of cache';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        Artisan::call('cache:clear');
        Artisan::call('view:clear');
        Artisan::call('view:cache');
        Artisan::call('config:clear');
        Artisan::call('config:cache');
        Artisan::call('event:clear');
        Artisan::call('event:cache');
        Artisan::call('route:cache');
        Artisan::call('route:clear');
    }
}
