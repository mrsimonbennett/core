<?php
namespace FullRent\Core\Company;

use SmoothPhp\Contracts\Serialization\Serializable;
use FullRent\Core\Company\ValueObjects\LandlordId;

/**
 * Class Landlord
 * @package FullRent\Core\Company
 * @author Simon Bennett <simon@bennett.im>
 */
final class Landlord implements Serializable, \SmoothPhp\Contracts\EventSourcing\Event
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

    /**
     * @return mixed The object instance
     */
    public static function deserialize(array $data)
    {
        return new static(new LandlordId($data['id']));
    }

    /**
     * @return array
     */
    public function serialize()
    {
        return ['id' => (string)$this->landlordId];
    }
}