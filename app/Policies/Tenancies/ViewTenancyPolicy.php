<?php
namespace FullRent\Core\Application\Policies\Tenancies;

use FullRent\Core\Application\Policies\BasePolicy;
use FullRent\Core\Tenancy\Queries\FindTenancyById;

/**
 * Class ViewTenancyPolicy
 * @package FullRent\Core\Application\Policies\Tenancies
 * @author Simon Bennett <simon@bennett.im>
 */
final class ViewTenancyPolicy extends BasePolicy
{
    /**
     * @param \stdClass $user
     * @param string $tenancyId
     * @return bool
     */
    public function check($user, $tenancyId)
    {
        if ($this->getUser($user)->role === 'landlord') {
            return true;
        }

        $tenancy = $this->queryBus->query(new FindTenancyById($tenancyId));

        foreach ($tenancy->tenants as $tenant) {
            if ($tenant->id == $user->id) {
                return true;
            }
        }

        return false;
    }
}