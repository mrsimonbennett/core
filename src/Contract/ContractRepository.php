<?php
namespace FullRent\Core\Contract;

use Broadway\Domain\AggregateRoot;

/**
 * Interface ContractRepository
 * @package FullRent\Core\Contract
 * @author Simon Bennett <simon@bennett.im>
 */
interface ContractRepository
{
    /**
     * @param $id
     * @return Contract
     */
    public function load($id);

    /**
     * @param AggregateRoot $aggregateRoot
     * @return void
     */
    public function save(AggregateRoot $aggregateRoot);
}