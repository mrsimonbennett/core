<?php namespace FullRent\Core\Application\Providers;

use FullRent\Core\Deposit\Listeners\DepositMySqlListenerV2;
use FullRent\Core\RentBook\Listeners\RentBookContractListener;
use FullRent\Core\RentBook\Listeners\RentBookMysqlListener;
use Illuminate\Contracts\Events\Dispatcher as DispatcherContract;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{

    /**
     * The event handler mappings for the application.
     *
     * @var array
     */
    protected $listen = [];

    /**
     * The subscriber classes to register.
     *
     * @var array
     */
    protected $subscribe = [
        DepositMySqlListenerV2::class,
        /**
         * Rent Book
         */
        RentBookContractListener::class,
        RentBookMysqlListener::class,
    ];

    /**
     * Register any other events for your application.
     *
     * @param  \Illuminate\Contracts\Events\Dispatcher $events
     * @return void
     */
    public function boot(DispatcherContract $events)
    {
        parent::boot($events);


    }

}
