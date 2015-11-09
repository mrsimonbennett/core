<?php
namespace FullRent\Core\Deposit\Repository;

use FullRent\Core\Deposit\Deposit;
use SmoothPhp\EventSourcing\EventSourcedRepository;

/**
 * Class SmoothDepositRepository
 * @package FullRent\Core\Deposit\Repository
 * @author Simon Bennett <simon@bennett.im>
 */
final class SmoothDepositRepository extends EventSourcedRepository implements DepositRepository
{

    /**
     * @return string
     */
    protected function getPrefix()
    {
        return 'deposit-';
    }

    protected function getAggregateType()
    {
        return Deposit::class;
    }
}