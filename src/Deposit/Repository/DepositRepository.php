<?php
namespace FullRent\Core\Deposit\Repository;

use Broadway\Domain\AggregateRoot;
use FullRent\Core\Deposit\Deposit;
use FullRent\Core\Deposit\ValueObjects\DepositId;

/**
 * Class DepositRepository
 * @package FullRent\Core\Deposit\Repository
 * @author Simon Bennett <simon@bennett.im>
 */
interface DepositRepository
{
    /**
     * @param DepositId $id
     * @return Deposit
     */
    public function load($id);

    /**
     * @param AggregateRoot $aggregateRoot
     * @return void
     */
    public function save(AggregateRoot $aggregateRoot);

}