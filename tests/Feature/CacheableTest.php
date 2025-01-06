<?php

use Illuminate\Support\Facades\Cache;
use Mimachh\Cacheable\Tests\Services\TestService;


it('caches a specific method', function () {
    $service = app(TestService::class);

    $uuid = $service->getUuid();

    expect($service->getUuid())->toBe($uuid);
    expect($service->getUuid())->toBe($uuid);
    sleep(3);
    expect($service->getUuid())->not()->toBe($uuid);
})->only();


it('caches a cacheable method under the right key', function () {
    expect(Cache::get('cached-method'))->toBeNull();

    $service = app(TestService::class);

    $service->getUuid();

    expect(Cache::get('cached-method'))->not()->toBeNull();
})->only();
