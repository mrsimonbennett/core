<?php
namespace App\Providers;
use Broadway\CommandHandling\SimpleCommandBus;
use FullRent\Core\CommandBus\CommandBus;
use FullRent\Core\CommandBus\LaravelCommandBus;
use FullRent\Core\CommandBus\SimpleCommandTranslator;
use Illuminate\Support\ServiceProvider;

final class CommandBusServiceProvider extends ServiceProvider
{

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(CommandBus::class,function ($app)
        {
           return new LaravelCommandBus(new SimpleCommandTranslator(),$app);
        });
    }
}