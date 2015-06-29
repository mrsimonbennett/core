<?php
namespace FullRent\Core\Property\Read\Subscribers;

use Carbon\Carbon;
use FullRent\Core\Infrastructure\Events\EventListener;
use FullRent\Core\Infrastructure\Mysql\MySqlClient;
use FullRent\Core\Property\Events\NewPropertyListed;
use FullRent\Core\Property\Events\PropertyAcceptingApplications;
use FullRent\Core\Property\Events\PropertyClosedAcceptingApplications;

/**
 * Class MysqlPropertySubscriber
 * @package FullRent\Core\Property\Read\Subscribers
 * @author Simon Bennett <simon@bennett.im>
 */
final class MysqlPropertySubscriber extends EventListener
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

    /**
     * @return array
     */
    protected function register()
    {
        return [
            'whenPropertyWasListed'           => NewPropertyListed::class,
            'whenPropertyAcceptsApplications' => PropertyAcceptingApplications::class,
            'whenPropertyApplicationsClose'   => PropertyClosedAcceptingApplications::class,
        ];
    }
}