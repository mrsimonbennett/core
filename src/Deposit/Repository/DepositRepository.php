<?php
namespace FullRent\Core\Deposit\Repository;

use FullRent\Core\Deposit\Deposit;
use FullRent\Core\Deposit\ValueObjects\DepositId;
use SmoothPhp\Contracts\EventSourcing\AggregateRoot;

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