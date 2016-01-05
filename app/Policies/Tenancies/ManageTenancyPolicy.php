<?php
namespace FullRent\Core\Application\Policies\Tenancies;

use FullRent\Core\Application\Policies\BasePolicy;

/**
 * Class ManageTenancyPolicy
 * @package FullRent\Core\Application\Policies\Tenancies
 * @author Simon Bennett <simon@bennett.im>
 */
final class ManageTenancyPolicy extends BasePolicy
{
    /**
     * @param $user
     * @return bool
     */
    public function check($user)
    {
        return $this->getUser($user)->role == 'landlord';
    }
}