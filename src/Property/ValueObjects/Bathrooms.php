<?php
namespace FullRent\Core\Property\ValueObjects;

use SmoothPhp\Contracts\Serialization\Serializable;

/**
 * Class Bathrooms
 * @package FullRent\Core\Property\ValueObjects
 * @author Simon Bennett <simon@bennett.im>
 */
final class Bathrooms implements Serializable, \SmoothPhp\Contracts\EventSourcing\Event
{
    /**
     * @var int
     */
    private $bathroomCount;

    /**
     * @param int $bathroomCount
     */
    public function __construct($bathroomCount)
    {
        $this->bathroomCount = $bathroomCount;
    }

    /**
     * @return int
     */
    public function getBathroomCount()
    {
        return $this->bathroomCount;
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
        return ['count' => $this->bathroomCount];
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string)$this->bathroomCount;
    }
}