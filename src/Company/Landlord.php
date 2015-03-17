<?php
namespace FullRent\Core\Company;

use FullRent\Core\Company\ValueObjects\LandlordId;

/**
 * Class Landlord
 * @package FullRent\Core\Company
 * @author Simon Bennett <simon@bennett.im>
 */
final class Landlord
{
    /**
     * @var LandlordId
     */
    private $landlordId;

    /**
     * @param LandlordId $landlordId
     */
    public function __construct(LandlordId $landlordId)
    {
        $this->landlordId = $landlordId;
    }

    /**
     * @return LandlordId
     */
    public function getLandlordId()
    {
        return $this->landlordId;
    }

}