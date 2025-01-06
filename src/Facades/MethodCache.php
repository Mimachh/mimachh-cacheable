<?php

namespace Mimachh\Cacheable\Facades;

use Illuminate\Support\Facades\Facade;
use Mimachh\Cacheable\Services\MethodCacheService;

class MethodCache extends Facade
{
    protected static function getFacadeAccessor()
    {
        return MethodCacheService::class;
    }
}
