<?php

namespace Mimachh\Cacheable\Actions;

use Mimachh\Cacheable\Attributes\Cacheable;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use ReflectionClass;

class OverrideCacheableMethodClassAction
{
    public function handle(string $class): void
    {
        $reflection = new ReflectionClass($class);
        $methods = $reflection->getMethods();

        $methodToOverride = collect($methods)->firstWhere(function ($method) {
            return count($method->getAttributes(Cacheable::class)) > 0;
        });

        $attribute = $methodToOverride->getAttributes(Cacheable::class)[0];
        $cacheableInstance = $attribute->newInstance();

        $keys = Cache::get('methodcache-keys', []);
        $keys[] = $cacheableInstance->key;
        Cache::forever('methodcache-keys', $keys);

        $methodeImplementation = function ($original) use ($cacheableInstance) {
            return Cache::remember(
                key: $cacheableInstance->key,
                ttl: $cacheableInstance->ttl,
                callback: fn() => $original()
            );
        };

        $methodOverider = resolve(MethodOverrider::class);
        $result = $methodOverider->generateOverriddenClass(
            class: $class,
            methodNames: $methodToOverride->name,
            implementations: $methodeImplementation
        );

        $filePath = storage_path('framework/cache/' . $result['className'] . '.php');
        File::put($filePath, $result['content']);

        try {
            require_once $filePath;
            $className = $result['className'];
            $overriddenClassInstance = new $className($result['implementations']);
        } finally {
            File::delete($filePath);
        }

        app()->bind($class, fn() => $overriddenClassInstance);
    }
}
