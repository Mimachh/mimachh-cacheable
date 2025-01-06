<?php

namespace Mimachh\Cacheable;

use Mimachh\Cacheable\Actions\OverrideCacheableMethodClassAction;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Mimachh\Cacheable\Commands\CacheableCommand;
use Mimachh\Cacheable\Console\MethodCacheCommand;
use Mimachh\Cacheable\Contracts\HasCacheableMethods;
use Mimachh\Cacheable\Tests\Services\TestService;

class CacheableServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('cacheable')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_cacheable_table')
            ->hasCommand(CacheableCommand::class);
    }

    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                MethodCacheCommand::class
            ]);
        }

        $this->rebindCacheableClasses();
    }

    protected function rebindCacheableClasses(): void
    {
        $this->app->beforeResolving(function ($abstract) {

            $class = is_string($abstract) ? $abstract : get_class($abstract);

            if (! class_exists($class)) {
                return;
            }

            if (! in_array(HasCacheableMethods::class, class_implements($class) ?: [], true)) {
                return;
            }

            app(OverrideCacheableMethodClassAction::class)->handle($class);
        });
    }
}
