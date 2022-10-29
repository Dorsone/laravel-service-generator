<?php

namespace Dorsone\LaravelService\Providers;

use Carbon\Laravel\ServiceProvider;
use Dorsone\LaravelService\Console\Commands\MakeServiceCommand;

class ServiceGeneratorProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                MakeServiceCommand::class,
            ]);
        };
    }
}
