<?php

namespace App\Console\Commands;

use App\Traits\CacheTimeout;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class forgetCache extends Command
{
    use CacheTimeout;
    protected $signature = 'forget:cache';

    protected $description = 'For Forget All of cache';

    public function handle()
    {
        $this->forgetAll();
    }
}
