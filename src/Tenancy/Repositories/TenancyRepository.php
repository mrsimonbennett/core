<?php
namespace FullRent\Core\Tenancy\Repositories;

use FullRent\Core\Tenancy\Tenancy;
use FullRent\Core\Tenancy\ValueObjects\TenancyId;
use SmoothPhp\Contracts\EventSourcing\AggregateRoot;

/**
 * Interface TenancyRepository
 * @package FullRent\Core\Tenancy\Repositories
 * @author Simon Bennett <simon@bennett.im>
 */
interface TenancyRepository
{
    /**
     * @param TenancyId $id
     * @return Tenancy
     */
    public function load($id);

    /**
     * @param AggregateRoot $aggregateRoot
     * @return void
     */
    public function save(AggregateRoot $aggregateRoot);
}