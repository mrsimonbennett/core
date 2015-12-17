<?php namespace FullRent\Core\Property\Entity;

use SmoothPhp\EventSourcing\Entity;
use FullRent\Core\Property\ValueObjects\PropertyId;
use FullRent\Core\Property\ValueObjects\Inventory\InventoryItemId;
use FullRent\Core\Property\ValueObjects\Inventory\InventoryItemName as Name;
use FullRent\Core\Property\ValueObjects\Inventory\InventoryItemDescription as Description;

/**
 * Class InventoryItem
 *
 * @author jrdn hannah <jrdn@jrdnhannah.co.uk>
 */
final class InventoryItem extends Entity
{
    /** @var InventoryItemId */
    private $id;

    /** @var PropertyId */
    private $propertyId;

    /** @var Name */
    private $name;

    /** @var Description */
    private $description;

    /**
     * @param PropertyId      $propertyId
     * @param InventoryItemId $id
     * @param Name            $name
     * @param Description     $description
     * @return static
     */
    public static function forProperty(PropertyId $propertyId, InventoryItemId $id, Name $name, Description $description)
    {
        $item = new static;
        $item->id = $id;
        $item->propertyId  = $propertyId;
        $item->name        = $name;
        $item->description = $description;

        return $item;
    }

    /**
     * @return string
     */
    public function getEntityId()
    {
        return 'inventory-item-' . (string) $this->id;
    }
}