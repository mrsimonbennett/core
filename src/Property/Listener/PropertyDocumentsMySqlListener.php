<?php
namespace FullRent\Core\Property\Listeners;

use FullRent\Core\Infrastructure\Mysql\MySqlClient;
use FullRent\Core\Property\Events\DocumentAttachedToProperty;
use FullRent\Core\Tenancy\Events\TenancyDrafted;
use SmoothPhp\Contracts\EventDispatcher\Projection;
use SmoothPhp\Contracts\EventDispatcher\Subscriber;

/**
 * Class PropertyDocumentsMySqlListener
 *
 * @package FullRent\Core\Property\Listeners
 * @author  jrdn hannah <jrdn@jrdnhannah.co.uk>
 */
final class PropertyDocumentsMySqlListener implements Subscriber, Projection
{
    /** @var MySqlClient */
    private $client;

    /**
     * TenancyMysqlListener constructor.
     *
     * @param MySqlClient $client
     */
    public function __construct(MySqlClient $client)
    {
        $this->client = $client;
    }

    /**
     * @param DocumentAttachedToProperty $e
     */
    public function whenDocumentAttachedToProperty(DocumentAttachedToProperty $e)
    {
        $this->client
            ->query()
            ->table('property_images')
            ->insert([
                 'property_id' => $e->getPropertyId(),
                 'document_id' => $e->getDocumentId(),
                 'attached_at' => $e->wasAttachedAt(),
             ]);
    }

    /**
     * @return array
     */
    public function getSubscribedEvents()
    {
        return [
            DocumentAttachedToProperty::class => ['whenDocumentAttachedToProperty'],
        ];
    }
}