<?php
namespace FullRent\Core\Application\Policies;
use FullRent\Core\Application\Http\Models\CompanyModal;
use FullRent\Core\QueryBus\QueryBus;
use FullRent\Core\User\Queries\FindUserById;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Contracts\Cache\Repository;

/**
 * Class BasePolicy
 * @package FullRent\Core\Application\Policies
 * @author Simon Bennett <simon@bennett.im>
 */
class BasePolicy
{
    use HandlesAuthorization;

    /** @var QueryBus */
    protected $queryBus;

    /** @var CompanyModal */
    protected $companyModal;

    /** @var Repository */
    protected $cache;

    /**
     * Create a new policy instance.
     *
     * @param QueryBus $queryBus
     * @param CompanyModal $companyModal
     * @param Repository $cache
     */
    public function __construct(QueryBus $queryBus, CompanyModal $companyModal, Repository $cache)
    {
        $this->queryBus = $queryBus;
        $this->companyModal = $companyModal;
        $this->cache = $cache;
    }

    public function getUser($user)
    {
        return $this->cache->remember('user-' . $user->id,
                                      1,
            function () use ($user){
                $user = $this->queryBus->query(new FindUserById($user->id));

                $user->role = 'tenant';

                foreach ($user->companies as $company) {
                    if ($company->id == $this->companyModal->id) {
                        $user->role = $company->role;
                    }
                }

                return $user;
            });
    }

}