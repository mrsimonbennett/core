<?php
namespace FullRent\Core\RentBook;

use FullRent\Core\RentBook\Listeners\RentBookAuthorizedListener;
use FullRent\Core\RentBook\Listeners\RentBookContractListener;
use FullRent\Core\RentBook\Listeners\RentBookMysqlListener;
use FullRent\Core\RentBook\Listeners\RentBookRentHistoryListener;
use FullRent\Core\RentBook\Repository\RentBookRepository;
use FullRent\Core\RentBook\Repository\SmoothRentBookRepository;
use Illuminate\Support\ServiceProvider;
use SmoothPhp\Contracts\EventDispatcher\EventDispatcher;

/**
 * Class RentBookServiceProvider
 * @package FullRent\Core\RentBook
 * @author Simon Bennett <simon@bennett.im>
 */
final class RentBookServiceProvider extends ServiceProvider
{

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(RentBookRepository::class, SmoothRentBookRepository::class);
    }
    public function boot()
    {
        /** @var EventDispatcher $dispatcher */
        $dispatcher = $this->app->make(EventDispatcher::class);

        $dispatcher->addSubscriber($this->app->make(RentBookAuthorizedListener::class));
        $dispatcher->addSubscriber($this->app->make(RentBookContractListener::class));
        $dispatcher->addSubscriber($this->app->make(RentBookMysqlListener::class));
        $dispatcher->addSubscriber($this->app->make(RentBookRentHistoryListener::class));
    }
}