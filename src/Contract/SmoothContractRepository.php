<?php
namespace FullRent\Core\Contract;

use SmoothPhp\EventSourcing\EventSourcedRepository;

/**
 * Class SmoothContractRepository
 * @package FullRent\Core\Contract
 * @author Simon Bennett <simon@bennett.im>
 */
final class SmoothContractRepository extends EventSourcedRepository implements ContractRepository
{

    /**
     * @return string
     */
    protected function getPrefix()
    {
        return 'contract-';
    }

    protected function getAggregateType()
    {
        return Contract::class;
    }
}