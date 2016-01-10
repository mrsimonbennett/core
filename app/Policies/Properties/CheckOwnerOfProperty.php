<?php
namespace FullRent\Core\Application\Policies\Properties;

use FullRent\Core\Application\Policies\BasePolicy;
use FullRent\Core\Property\Queries\FindPropertyById;

/**
 * Class CheckOwnerOfProperty
 * @package FullRent\Core\Application\Policies\Properties
 * @author Simon Bennett <simon@bennett.im>
 */
final class CheckOwnerOfProperty extends BasePolicy
{
    /**
     * @param $user
     * @param $propertyId
     * @return bool
     */
    public function check($user, $propertyId)
    {
        $property = $this->queryBus->query(new FindPropertyById($propertyId));

        return $this->getUser($user)->role == 'landlord' && $user->id == $property->landlord_id;
    }
}