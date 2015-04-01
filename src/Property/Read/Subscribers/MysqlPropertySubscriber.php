<?php
namespace FullRent\Core\Property\Read\Subscribers;

use Carbon\Carbon;
use FullRent\Core\Infrastructure\Subscribers\BaseMysqlSubscriber;
use FullRent\Core\Property\Events\NewPropertyListed;

/**
 * Class MysqlPropertySubscriber
 * @package FullRent\Core\Property\Read\Subscribers
 * @author Simon Bennett <simon@bennett.im>
 */
final class MysqlPropertySubscriber extends BaseMysqlSubscriber
{
    /**
     * @param NewPropertyListed $newPropertyListed
     * @hears("FullRent.Core.Property.Events.NewPropertyListed")
     */
    public function whenPropertyWasListed(NewPropertyListed $newPropertyListed)
    {
        $this->db
            ->table('properties')
            ->insert([
                         'id'                => $newPropertyListed->getPropertyId(),
                         'address_firstline' => $newPropertyListed->getAddress()->getAddress(),
                         'address_city'      => $newPropertyListed->getAddress()->getCity(),
                         'address_county'    => $newPropertyListed->getAddress()->getCounty(),
                         'address_country'   => $newPropertyListed->getAddress()->getCountry(),
                         'address_postcode'  => $newPropertyListed->getAddress()->getPostcode(),
                         'company_id'        => $newPropertyListed->getCompany()->getCompanyId(),
                         'landlord_id'       => $newPropertyListed->getLandlord()->getLandlordId(),
                         'bedrooms'          => $newPropertyListed->getBathrooms(),
                         'bathrooms'         => $newPropertyListed->getBathrooms(),
                         'parking'           => $newPropertyListed->getParking(),
                         'pets'              => $newPropertyListed->getPets(),
                         'created_at'        => $newPropertyListed->getListedAt(),
                         'updated_at'        => Carbon::now(),
                     ]);
    }
}