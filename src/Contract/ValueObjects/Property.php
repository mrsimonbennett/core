<?php
namespace FullRent\Core\Contract\ValueObjects;

use Broadway\Serializer\SerializableInterface;

/**
 * Class Property
 * @package FullRent\Core\Contract
 * @author Simon Bennett <simon@bennett.im>
 */
final class Property implements SerializableInterface
{
    /**
     * @var PropertyId
     */
    private $propertyId;

    /**
     * @param PropertyId $propertyId
     */
    public function __construct(PropertyId $propertyId)
    {
        $this->propertyId = $propertyId;
    }

    /**
     * @return PropertyId
     */
    public function getPropertyId()
    {
        return $this->propertyId;
    }

    /**
     * @param array $data
     * @return mixed The object instance
     */
    public static function deserialize(array $data)
    {
        return new static(new PropertyId($data['id']));
    }

    /**
     * @return array
     */
    public function serialize()
    {
        return ['id' => (string)$this->propertyId];
    }
}