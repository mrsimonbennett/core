<?php
namespace FullRent\Core\Property\Listener;

use FullRent\Core\Infrastructure\Mysql\MySqlClient;
use FullRent\Core\Property\Events\AmendedPropertyAddress;
use FullRent\Core\Property\Events\PropertyExtraInformationAmended;
use SmoothPhp\Contracts\EventDispatcher\Projection;
use SmoothPhp\Contracts\EventDispatcher\Subscriber;

/**
 * Class PropertyMysqlListenerV2
 * @package FullRent\Core\Property\Listener
 * @author Simon Bennett <simon@bennett.im>
 */
final class PropertyMysqlListenerV2 implements Projection, Subscriber
{
    /** @var MySqlClient */
    private $client;

    /**
     * PropertyMysqlListenerV2 constructor.
     * @param MySqlClient $client
     */
    public function __construct(MySqlClient $client)
    {
        $this->client = $client;
    }

    public function whenPropertyAddressAmendedUpDateMysql(AmendedPropertyAddress $e)
    {
        $this->client->query()
                     ->table('properties')
                     ->where('id', $e->getId())
                     ->update([
                                  'address_firstline' => $e->getAddress()->getAddress(),
                                  'address_city'      => $e->getAddress()->getCity(),
                                  'address_county'    => $e->getAddress()->getCounty(),
                                  'address_country'   => $e->getAddress()->getCountry(),
                                  'address_postcode'  => $e->getAddress()->getPostcode(),
                              ]);
    }

    /**
     * @param PropertyExtraInformationAmended $e
     */
    public function whenPropertyExtraInformationAmended(PropertyExtraInformationAmended $e)
    {
        $this->client->query()
                     ->table('properties')
                     ->where('id', $e->getId())
                     ->update([
                                  'bedrooms'  => $e->getBathrooms(),
                                  'bathrooms' => $e->getBathrooms(),
                                  'parking'   => $e->getParking(),
                                  'pets'      => $e->getPets(),
                              ]);
    }

    /**
     * ['eventName' => 'methodName']
     * ['eventName' => ['methodName', $priority]]
     * ['eventName' => [['methodName1', $priority], array['methodName2']]
     * @return array
     */
    public function getSubscribedEvents()
    {
        return [
            AmendedPropertyAddress::class          => 'whenPropertyAddressAmendedUpDateMysql',
            PropertyExtraInformationAmended::class => 'whenPropertyExtraInformationAmended',
        ];
    }
}