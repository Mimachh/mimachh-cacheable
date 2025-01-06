<?php

namespace Mimachh\Cacheable\Tests\Services;

use Illuminate\Support\Str;
use Mimachh\Cacheable\Attributes\Cacheable;
use Mimachh\Cacheable\Contracts\HasCacheableMethods;

class TestService implements HasCacheableMethods
{
    #[Cacheable(ttl: 1, key: 'cached-method')]
    public function getUuid(): string
    {
        return Str::uuid();
    }
}
