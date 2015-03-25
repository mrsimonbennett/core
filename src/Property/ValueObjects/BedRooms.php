<?php
namespace FullRent\Core\Property\ValueObjects;

use Broadway\Serializer\SerializableInterface;

/**
 * Class BedRooms
 * @package FullRent\Core\Property\ValueObjects
 * @author Simon Bennett <simon@bennett.im>
 */
final class BedRooms implements SerializableInterface
{
    /**
     * @var int
     */
    private $bedroomCount;

    /**
     * @param int $bedroomCount
     */
    public function __construct($bedroomCount)
    {
        $this->bedroomCount = $bedroomCount;
    }

    /**
     * @return int
     */
    public function getBedroomCount()
    {
        return $this->bedroomCount;
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
        return ['count' => $this->bedroomCount];
    }
}