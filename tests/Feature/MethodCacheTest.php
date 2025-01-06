<?php

use Illuminate\Support\Facades\Cache;
use Mimachh\Cacheable\Facades\MethodCache;
use Mimachh\Cacheable\Tests\Services\TestService;

it('clears all items cached by our package', function () {
    $service = app(TestService::class);
    $service->getUuid();
    Cache::put('some-key', 'some-value');
    MethodCache::flush();

    expect(Cache::get('cached-method'))->toBeNull();
    expect(Cache::get('some-key'))->not()->toBeNull();
})->only();
