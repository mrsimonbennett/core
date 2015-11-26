<?php
namespace FullRent\Core\Tenancy\Repositories;

use FullRent\Core\Tenancy\Tenancy;
use SmoothPhp\EventSourcing\EventSourcedRepository;

/**
 * Class SmoothTenancyRepository
 * @package FullRent\Core\Tenancy\Repositories
 * @author Simon Bennett <simon@bennett.im>
 */
final class SmoothTenancyRepository extends EventSourcedRepository implements TenancyRepository
{

    /**
     * @return string
     */
    protected function getPrefix()
    {
        return 'tenancy-';
    }

    /**
     * @return string
     */
    protected function getAggregateType()
    {
        return Tenancy::class;
    }
}