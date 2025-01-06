<?php

use Illuminate\Support\Facades\Cache;
use Mimachh\Cacheable\Console\MethodCacheCommand;
use Mimachh\Cacheable\Tests\Services\TestService;

it('clears all cached items by our package', function () {
    $service = app(TestService::class);
    $service->getUuid();
    Cache::put('some-key', 'some-value');

    $this->artisan(MethodCacheCommand::class);

    expect(Cache::get('cached-method'))->toBeNull();
    expect(Cache::get('some-key'))->not()->toBeNull();
})->only();
