<?php namespace FullRent\Core\Images;

use FullRent\Core\Images\Repository\ImageRepository;
use FullRent\Core\Images\Repository\SmoothImageRepository;
use FullRent\Core\Infrastructure\FullRentServiceProvider;

/**
 * Class ImageServiceProvider
 * @package FullRent\Core\Images
 * @author jrdn hannah <jrdn@jrdnhannah.co.uk>
 */
final class ImageServiceProvider extends FullRentServiceProvider
{

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(ImageRepository::class, SmoothImageRepository::class);
    }

    /**
     * @return array
     */
    function getEventSubscribers()
    {
        return [        ];
    }
}