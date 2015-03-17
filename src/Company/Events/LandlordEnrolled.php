<?php
namespace FullRent\Core\Company\Events;

use FullRent\Core\Company\Landlord;
use FullRent\Core\Company\ValueObjects\CompanyId;

/**
 * Class LandlordEnrolled
 * @package FullRent\Core\Company\Events
 * @author Simon Bennett <simon@bennett.im>
 */
final class LandlordEnrolled
{

    /**
     * @var CompanyId
     */
    private $contractId;
    /**
     * @var Landlord
     */
    private $landlord;

    /**
     * @param CompanyId $contractId
     * @param Landlord $landlord
     */
    public function __construct(CompanyId $contractId, Landlord $landlord)
    {

        $this->contractId = $contractId;
        $this->landlord = $landlord;
    }

    /**
     * @return CompanyId
     */
    public function getContractId()
    {
        return $this->contractId;
    }

    /**
     * @return Landlord
     */
    public function getLandlord()
    {
        return $this->landlord;
    }


}