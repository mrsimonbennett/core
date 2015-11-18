<?php
namespace FullRent\Core\Deposit\Listeners;

use FullRent\Core\Contract\Events\LandlordSignedContract;
use FullRent\Core\Contract\Query\FindContractByIdQuery;
use FullRent\Core\Deposit\Commands\SetupDeposit;
use FullRent\Core\QueryBus\QueryBus;
use SmoothPhp\Contracts\CommandBus\CommandBus;
use SmoothPhp\Contracts\EventDispatcher\Subscriber;

/**
 * Class ContractListener
 *
 * The deposits section listing to the Contract Events
 *
 * @package FullRent\Core\Deposit\Listeners
 * @author Simon Bennett <simon@bennett.im>
 */
final class ContractListener implements Subscriber
{
    /**
     * @var CommandBus
     */
    private $commandBus;

    /**
     * @var QueryBus
     */
    private $queryBus;

    /**
     * @param CommandBus $commandBus
     * @param QueryBus $queryBus
     */
    public function __construct(CommandBus $commandBus, QueryBus $queryBus)
    {
        $this->commandBus = $commandBus;
        $this->queryBus = $queryBus;
    }

    /**
     * When a contract is complete we build the deposits for each tenant
     *
     * This handler only fires when a contract is signed, and not on event rebuild
     *
     * @param LandlordSignedContract $e
     */
    public function whenContractedCompleted(LandlordSignedContract $e)
    {
        $contract = $this->queryBus->query(new FindContractByIdQuery((string)$e->getContractId()));

        foreach ($contract->tenants as $tenant) {
            $this->commandBus->execute(new SetupDeposit(uuid(),
                                                        $contract->id,
                                                        $tenant->tenant_id,
                                                        $contract->deposit,
                                                        $contract->deposit_due,
                                                        boolval($contract->fullrent_deposit)));

        }

    }
    /**
     * @return array
     */
    public function getSubscribedEvents()
    {
        return [
            LandlordSignedContract::class => ['whenContractedCompleted'],
        ];
    }
}