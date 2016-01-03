<?php
namespace FullRent\Core\Application\Http\Composer\Dashboard;

use FullRent\Core\Application\Http\Composer\Composer;
use FullRent\Core\Application\Http\Models\CompanyModal;
use FullRent\Core\QueryBus\QueryBus;
use FullRent\Core\User\Queries\FindUserById;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Cache\Repository;
use Illuminate\Contracts\View\View;

/**
 * Class AllDashboardComposer
 * @package FullRent\Core\Application\Http\Composer\Dashboard
 * @author Simon Bennett <simon@bennett.im>
 */
final class AllDashboardComposer implements Composer
{
    /** @var Guard */
    private $guard;

    /** @var QueryBus */
    private $queryBus;

    /** @var Repository */
    private $cache;

    /** @var CompanyModal */
    private $companyModal;

    /**
     * AllDashboardComposer constructor.
     * @param Guard $guard
     * @param QueryBus $queryBus
     * @param Repository $cache
     * @param CompanyModal $companyModal
     */
    public function __construct(Guard $guard, QueryBus $queryBus, Repository $cache, CompanyModal $companyModal)
    {
        $this->guard = $guard;
        $this->queryBus = $queryBus;
        $this->cache = $cache;
        $this->companyModal = $companyModal;
    }

    /**
     * @param View $view
     */
    public function compose(View $view)
    {


        $user = $this->cache->remember('user-' . $this->guard->user()->id,
                                       1,
            function () {
                $user = $this->queryBus->query(new FindUserById($this->guard->user()->id));

                $user->role = 'tenant';

                foreach ($user->companies as $company) {
                    if ($company->id == $this->companyModal->id) {
                        $user->role = $company->role;
                    }
                }

                return $user;
            });

        $view->with('currentUser', $user);

    }
}