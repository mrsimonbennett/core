<?php
namespace FullRent\Core\RentBook;

use FullRent\Core\RentBook\Repository\BroadwayRentBookRepository;
use FullRent\Core\RentBook\Repository\RentBookRepository;
use Illuminate\Support\ServiceProvider;

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
        $this->app->bind(RentBookRepository::class, BroadwayRentBookRepository::class);
    }
}