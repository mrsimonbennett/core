<?php
namespace FullRent\Core\Property\Read\Subscribers;

use Carbon\Carbon;
use FullRent\Core\Infrastructure\Events\EventListener;
use FullRent\Core\Infrastructure\Mysql\MySqlClient;
use FullRent\Core\Property\Events\ImageAttachedToProperty;
use FullRent\Core\Property\Events\NewPropertyListed;
use FullRent\Core\Property\Events\PropertyAcceptingApplications;
use FullRent\Core\Property\Events\PropertyClosedAcceptingApplications;
use SmoothPhp\Contracts\EventDispatcher\Projection;
use SmoothPhp\Contracts\EventDispatcher\Subscriber;

/**
 * Class MysqlPropertySubscriber
 * @package FullRent\Core\Property\Read\Subscribers
 * @author Simon Bennett <simon@bennett.im>
 */
final class MysqlPropertySubscriber implements Projection, Subscriber
{
    /**
     * @var MySqlClient
     */
    private $client;

    /**
     * @param MySqlClient $client
     */
    public function __construct(MySqlClient $client)
    {
        $this->client = $client;
    }

    /**
     * @param NewPropertyListed $e
     */
    public function whenPropertyWasListed(NewPropertyListed $e)
    {
        $this->client->query()
                     ->table('properties')
                     ->insert([
                                  'id'                => $e->getPropertyId(),
                                  'address_firstline' => $e->getAddress()->getAddress(),
                                  'address_city'      => $e->getAddress()->getCity(),
                                  'address_county'    => $e->getAddress()->getCounty(),
                                  'address_country'   => $e->getAddress()->getCountry(),
                                  'address_postcode'  => $e->getAddress()->getPostcode(),
                                  'company_id'        => $e->getCompany()->getCompanyId(),
                                  'landlord_id'       => $e->getLandlord()->getLandlordId(),
                                  'bedrooms'          => $e->getBathrooms(),
                                  'bathrooms'         => $e->getBathrooms(),
                                  'parking'           => $e->getParking(),
                                  'pets'              => $e->getPets(),
                                  'created_at'        => $e->getListedAt(),
                                  'updated_at'        => Carbon::now(),
                              ]);
    }

    /**
     * @param PropertyAcceptingApplications $e
     */
    public function  whenPropertyAcceptsApplications(PropertyAcceptingApplications $e)
    {
        $this->client->query()
                     ->table('properties')
                     ->where('id', (string)$e->getPropertyId())
                     ->update(['accepting_applications' => 1]);
    }

    /**
     * @param PropertyClosedAcceptingApplications $e
     */
    public function whenPropertyApplicationsClose(PropertyClosedAcceptingApplications $e)
    {
        $this->client->query()
                     ->table('properties')
                     ->where('id', $e->getPropertyId())
                     ->update(['accepting_applications' => false]);

    }

    public function whenImageAttachedToProperty(ImageAttachedToProperty $e)
    {
        $this->client->query()
                     ->table('property_images')
                     ->insert([
                         'property_id' => $e->getPropertyId(),
                         'image_id'    => $e->getImageId(),
                     ]);
    }

    /**
     * @return array
     */
    public function getSubscribedEvents()
    {
        return [
            NewPropertyListed::class => ['whenPropertyWasListed'],
            PropertyAcceptingApplications::class => ['whenPropertyAcceptsApplications'],
            PropertyClosedAcceptingApplications::class => ['whenPropertyApplicationsClose'],
            ImageAttachedToProperty::class => ['whenImageAttachedToProperty'],
        ];
    }
}