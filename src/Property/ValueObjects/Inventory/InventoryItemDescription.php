<?php namespace FullRent\Core\Property\ValueObjects\Inventory;

use SmoothPhp\Contracts\Serialization\Serializable;

/**
 * Class InventoryItemDescription
 *
 * @author jrdn hannah <jrdn@jrdnhannah.co.uk>
 */
final class InventoryItemDescription implements Serializable
{
    /** @var string */
    private $description;

    /**
     * @param string $description
     */
    public function __construct($description)
    {
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param array $data The serialized data
     * @return static The object instance
     */
    public static function deserialize(array $data)
    {
        return new static($data['description']);
    }

    /**
     * @return array
     */
    public function serialize()
    {
        return ['description' => $this->description];
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->description;
    }
}