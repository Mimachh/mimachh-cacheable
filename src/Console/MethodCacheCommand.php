<?php

namespace Mimachh\Cacheable\Console;

use Illuminate\Console\Command;
use Mimachh\Cacheable\Facades\MethodCache;

class MethodCacheCommand extends Command
{
    protected $signature = "methodcache:flush";

    protected $description = "Flush all items cached by our cacheable attribute.";

    public function handle(): void
    {
        MethodCache::flush();
    }
}
