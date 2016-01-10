<?php
namespace FullRent\Core\Application\Policies\Properties;

use FullRent\Core\Application\Policies\BasePolicy;

/**
 * Class ListPropertyPolicy
 * @package FullRent\Core\Application\Policies\Properties
 * @author Simon Bennett <simon@bennett.im>
 */
final class ListPropertyPolicy extends BasePolicy
{
    public function check($user)
    {
        return $this->getUser($user)->role == 'landlord';
    }
}