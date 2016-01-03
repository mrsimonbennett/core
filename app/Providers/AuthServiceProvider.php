<?php
namespace FullRent\Core\Application\Providers;

use FullRent\Core\Application\Policies\Properties\CheckOwnerOfProperty;
use FullRent\Core\Application\Policies\Properties\ListPropertyPolicy;
use FullRent\Core\Application\Policies\Tenancies\ViewAllCompanyTenanciesPolicy;
use FullRent\Core\Application\Policies\ViewAllProperties;
use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

/**
 * Class AuthServiceProvider
 * @package FullRent\Core\Application\Providers
 * @author Simon Bennett <simon@bennett.im>
 */
final class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
    ];

    /**
     * Register any application authentication / authorization services.
     *
     * @param  \Illuminate\Contracts\Auth\Access\Gate $gate
     * @return void
     */
    public function boot(GateContract $gate)
    {
        $this->registerPolicies($gate);

        $this->definePolices(
            [
                'view_all_properties' => ViewAllProperties::class,
                'view_property'       => CheckOwnerOfProperty::class,
                'edit_property'       => CheckOwnerOfProperty::class,
                'list_property'       => ListPropertyPolicy::class,

                /*
                 * Tenanices
                 */
                'view_all_tenancies'  => ViewAllCompanyTenanciesPolicy::class,
            ],
            $gate);
    }

    private function definePolices(array $policies, GateContract $gate)
    {
        foreach ($policies as $policyName => $class) {
            $gate->define($policyName, $class . '@check');
        }
    }

}