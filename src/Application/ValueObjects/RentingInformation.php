<?php
namespace FullRent\Core\Application\ValueObjects;

use Broadway\Serializer\SerializableInterface;

/**
 * Class RentingInformation
 * @package FullRent\Core\Application\ValueObjects
 * @author Simon Bennett <simon@bennett.im>
 */
final class RentingInformation implements SerializableInterface
{
    /**
     * @var bool
     */
    private $currentlyRenting;

    /**
     * @param bool $currentlyRenting
     */
    public function __construct($currentlyRenting)
    {
        $this->currentlyRenting = $currentlyRenting;
    }

    /**
     * @return bool
     */
    public function isCurrentlyRenting()
    {
        return $this->currentlyRenting;
    }

    /**
     * @param array $data
     * @return mixed The object instance
     */
    public static function deserialize(array $data)
    {
        return new static((bool)$data['currently_renting']);
    }

    /**
     * @return array
     */
    public function serialize()
    {
        return ['currently_renting' => (bool)$this->currentlyRenting];
    }
}