<?php
namespace FullRent\Core\Company\Events;

use SmoothPhp\Contracts\Serialization\Serializable;
use FullRent\Core\Company\Landlord;
use FullRent\Core\Company\ValueObjects\CompanyId;

/**
 * Class LandlordEnrolled
 * @package FullRent\Core\Company\Events
 * @author Simon Bennett <simon@bennett.im>
 */
final class LandlordEnrolled implements Serializable, \SmoothPhp\Contracts\EventSourcing\Event
{

    /**
     * @var CompanyId
     */
    private $companyId;
    /**
     * @var Landlord
     */
    private $landlord;

    /**
     * @param CompanyId $companyId
     * @param Landlord $landlord
     */
    public function __construct(CompanyId $companyId, Landlord $landlord)
    {

        $this->companyId = $companyId;
        $this->landlord = $landlord;
    }

    /**
     * @return CompanyId
     */
    public function getCompanyId()
    {
        return $this->companyId;
    }

    /**
     * @return Landlord
     */
    public function getLandlord()
    {
        return $this->landlord;
    }


    /**
     * @param array $data
     * @return mixed The object instance
     */
    public static function deserialize(array $data)
    {
        return new static(new CompanyId($data['company_id']), Landlord::deserialize($data['landlord']));
    }

    /**
     * @return array
     */
    public function serialize()
    {
        return [
            'company_id' => (string)$this->companyId,
            'landlord' => $this->landlord->serialize(),
        ];
    }
}