<?php
namespace FullRent\Core\Contract\ValueObjects;

use Broadway\Serializer\SerializableInterface;

/**
 * Class Landlord
 * @package FullRent\Core\Contract
 * @author Simon Bennett <simon@bennett.im>
 */
final class Landlord implements SerializableInterface
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