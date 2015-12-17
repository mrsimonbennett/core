<?php namespace FullRent\Core\Property\ValueObjects\Inventory;

use SmoothPhp\Contracts\Serialization\Serializable;

/**
 * Class InventoryItemName
 *
 * @author jrdn hannah <jrdn@jrdnhannah.co.uk>
 */
final class InventoryItemName implements Serializable
{
    /** @var string */
    private $name;

    /**
     * @param string $name
     */
    public function __construct($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param array $data The serialized data
     * @return static The object instance
     */
    public static function deserialize(array $data)
    {
        return new static($data['name']);
    }

    /**
     * @return array
     */
    public function serialize()
    {
        return ['name' => $this->name];
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->name;
    }
}