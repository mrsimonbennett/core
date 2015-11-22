<?php namespace FullRent\Core\Property\Read\Subscribers;

use Illuminate\Database\Connection;
use Illuminate\Database\DatabaseManager;
use FullRent\Core\Infrastructure\Events\EventListener;
use FullRent\Core\Property\Events\ImageAttachedToProperty;
use SmoothPhp\Contracts\EventDispatcher\Projection;
use SmoothPhp\Contracts\EventDispatcher\Subscriber;

/**
 * Class PropertyImagesSubscriber
 * @package FullRent\Core\Property\Read\Subscribers
 * @author jrdn hannah <jrdn@jrdnhannah.co.uk>
 */
final class PropertyImagesSubscriber implements Subscriber, Projection
{
    /** @var DatabaseManager */
    protected $db;

    /**
     * @param DatabaseManager $db
     */
    public function __construct(DatabaseManager $db)
    {
        $this->db = $db;
    }

    /**
     * @param ImageAttachedToProperty $e
     */
    public function whenImageAttachedToProperty(ImageAttachedToProperty $e)
    {
        $this->db
            ->table('property_images')
            ->insert([
                'property_id' => $e->getPropertyId(),
                'image_id'    => $e->getImageId(),
                'attached_at' => $e->wasAttachedAt(),
            ]);
    }

    /**
     * @return array
     */
    public function getSubscribedEvents()
    {
        return [
            ImageAttachedToProperty::class => ['whenImageAttachedToProperty'],
        ];
    }
}