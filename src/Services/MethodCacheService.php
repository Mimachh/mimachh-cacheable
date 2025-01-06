<?php

namespace Mimachh\Cacheable\Services;

use Illuminate\Support\Facades\Cache;

class MethodCacheService
{
    public function flush(): void
    {
        collect(Cache::get('methodcache-keys', []))->each(fn($key) => Cache::forget($key));
        Cache::forget('methodcache-keys');
    }
}
