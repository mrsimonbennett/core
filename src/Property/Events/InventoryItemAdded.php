<?php namespace FullRent\Core\Property\Events;

use SmoothPhp\Contracts\EventSourcing\Event;
use FullRent\Core\Property\ValueObjects\PropertyId;
use SmoothPhp\Contracts\Serialization\Serializable;
use FullRent\Core\Property\ValueObjects\Inventory\InventoryItemId;
use FullRent\Core\Property\ValueObjects\Inventory\InventoryItemName;
use FullRent\Core\Property\ValueObjects\Inventory\InventoryItemDescription;

/**
 * Class InventoryItemAdded
 *
 * @author jrdn hannah <jrdn@jrdnhannah.co.uk>
 */
final class InventoryItemAdded implements Serializable, Event
{
    /** @var PropertyId */
    private $propertyId;
    /** @var InventoryItemId */
    private $itemId;
    /** @var InventoryItemName */
    private $name;
    /** @var InventoryItemDescription */
    private $description;

    /**
     * InventoryItemAdded constructor.
     *
     * @param PropertyId               $propertyId
     * @param InventoryItemId          $itemId
     * @param InventoryItemName        $name
     * @param InventoryItemDescription $description
     */
    public function __construct(
        PropertyId $propertyId,
        InventoryItemId $itemId,
        InventoryItemName $name,
        InventoryItemDescription $description
    ) {
        $this->propertyId = $propertyId;
        $this->itemId = $itemId;
        $this->name = $name;
        $this->description = $description;
    }

    /**
     * @return PropertyId
     */
    public function getPropertyId()
    {
        return $this->propertyId;
    }

    /**
     * @return InventoryItemId
     */
    public function getItemId()
    {
        return $this->itemId;
    }

    /**
     * @return InventoryItemName
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return InventoryItemDescription
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return array
     */
    public function serialize()
    {
        return [
            'property_id' => $this->propertyId,
            'item_id'     => $this->itemId,
            'name'        => $this->name,
            'description' => $this->description,
        ];
    }

    /**
     * @param array $data
     * @return static
     */
    public static function deserialize(array $data)
    {
        return new static(
            new PropertyId($data['property_id']),
            new InventoryItemId($data['item_id']),
            new InventoryItemName($data['name']),
            new InventoryItemDescription($data['description'])
        );
    }
}