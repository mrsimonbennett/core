<?php namespace FullRent\Core\Property\Read\Subscribers;

use Illuminate\Database\Connection;
use Illuminate\Database\DatabaseManager;
use FullRent\Core\Infrastructure\Mysql\MySqlClient;
use SmoothPhp\Contracts\EventDispatcher\Projection;
use SmoothPhp\Contracts\EventDispatcher\Subscriber;
use FullRent\Core\Property\Events\ImageAttachedToProperty;
use FullRent\Core\Property\Events\ImageRemovedFromProperty;

/**
 * Class PropertyImagesSubscriber
 * @package FullRent\Core\Property\Read\Subscribers
 * @author jrdn hannah <jrdn@jrdnhannah.co.uk>
 */
final class PropertyImagesSubscriber implements Subscriber, Projection
{
    /** @var MySqlClient */
    protected $db;

    /**
     * @param MySqlClient $db
     */
    public function __construct(MySqlClient $db)
    {
        $this->db = $db;
    }

    /**
     * @param ImageAttachedToProperty $e
     */
    public function whenImageAttachedToProperty(ImageAttachedToProperty $e)
    {
        $this->db->query()
            ->table('property_images')
            ->insert([
                'property_id' => $e->getPropertyId(),
                'image_id'    => $e->getImageId(),
                'attached_at' => $e->wasAttachedAt(),
            ]);
    }

    /**
     * @param ImageRemovedFromProperty $e
     */
    public function whenImageRemovedFromProperty(ImageRemovedFromProperty $e)
    {
        $this->db->query()
            ->table('property_images')
            ->where('property_id', '=', $e->getPropertyId())
            ->where('image_id', '=', $e->getImageId())
            ->update(['deleted_at' => $e->getRemovedAt()]);
    }

    /**
     * @return array
     */
    public function getSubscribedEvents()
    {
        return [
            ImageAttachedToProperty::class  => ['whenImageAttachedToProperty'],
            ImageRemovedFromProperty::class => ['whenImageRemovedFromProperty'],
        ];
    }
}