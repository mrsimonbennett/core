<?php
namespace FullRent\Core\Application\Policies\Tenancies;

use FullRent\Core\Application\Policies\BasePolicy;

/**
 * Class ViewAllCompanyTenanciesPolicy
 * @package FullRent\Core\Application\Policies\Tenanies
 * @author Simon Bennett <simon@bennett.im>
 */
final class ViewAllCompanyTenanciesPolicy extends BasePolicy
{
    public function check($user)
    {
        return $this->getUser($user)->role == 'landlord';
    }
}