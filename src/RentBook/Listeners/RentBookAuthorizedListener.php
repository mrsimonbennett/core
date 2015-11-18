<?php
namespace FullRent\Core\RentBook\Listeners;

use FullRent\Core\Company\Queries\FindCompanyByIdQuery;
use FullRent\Core\Contract\Query\FindContractByIdQuery;
use FullRent\Core\QueryBus\QueryBus;
use FullRent\Core\RentBook\Commands\RentBookCreateBills;
use FullRent\Core\RentBook\Events\RentBookDirectDebitPreAuthorized;
use FullRent\Core\RentBook\Queries\FindRentBookQueryById;
use FullRent\Core\Services\DirectDebit\GoCardLess\GoCardLessAccessTokens;
use SmoothPhp\Contracts\CommandBus\CommandBus;
use SmoothPhp\Contracts\EventDispatcher\Subscriber;

/**
 * Class RentBookAuthorizedListener
 * @package FullRent\Core\RentBook\Listeners
 * @author Simon Bennett <simon@bennett.im>
 */
final class RentBookAuthorizedListener implements Subscriber
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
     * When the rent book is pre authorized with gocardless send gocardless the bill dates
     *
     *
     * @param RentBookDirectDebitPreAuthorized $e
     */
    public function whenRentBookAuthorized(RentBookDirectDebitPreAuthorized $e)
    {
        $rentBook = $this->queryBus->query(new FindRentBookQueryById($e->getRentBookId()));
        $contract = $this->queryBus->query(new FindContractByIdQuery($rentBook->contract_id));
        $company = $this->queryBus->query(new FindCompanyByIdQuery($contract->company_id));


        $accessToken = new GoCardLessAccessTokens($company->gocardless_merchant,
                                                  $company->gocardless_token);

        $this->commandBus->execute(new RentBookCreateBills((string)$e->getRentBookId(), $accessToken));
    }

    /**
     * @return array
     */
    public function getSubscribedEvents()
    {
        return [
            RentBookDirectDebitPreAuthorized::class => ['whenRentBookAuthorized'],
        ];
    }
}