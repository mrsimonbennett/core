<?php
namespace FullRent\Core\Property\ValueObjects;

use Broadway\Serializer\SerializableInterface;

/**
 * Class Parking
 * @package FullRent\Core\Property\ValueObjects
 * @author Simon Bennett <simon@bennett.im>
 */
final class Parking implements SerializableInterface
{
    /**
     * @var int
     */
    private $parkingCount;

    /**
     * @param int $parkingCount
     */
    public function __construct($parkingCount)
    {
        $this->parkingCount = $parkingCount;
    }

    /**
     * @return int
     */
    public function getParkingCount()
    {
        return $this->parkingCount;
    }
    /**
     * @return mixed The object instance
     */
    public static function deserialize(array $data)
    {
        return new static($data['count']);
    }

    /**
     * @return array
     */
    public function serialize()
    {
        return ['count' => $this->parkingCount];
    }
    /**
     * @return string
     */
    public function __toString()
    {
        return (string)$this->parkingCount;
    }
}