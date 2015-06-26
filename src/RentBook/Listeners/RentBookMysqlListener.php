<?php
namespace FullRent\Core\RentBook\Listeners;

use FullRent\Core\Infrastructure\Events\EventListener;
use FullRent\Core\Infrastructure\Mysql\MySqlClient;
use FullRent\Core\RentBook\Events\RentBookOpenedAutomatic;
use FullRent\Core\RentBook\Events\RentDueSet;

/**
 * Class RentBookMysqlListener
 * @package FullRent\Core\RentBook\Listeners
 * @author Simon Bennett <simon@bennett.im>
 */
final class RentBookMysqlListener extends EventListener
{
    /**
     * @var MySqlClient
     */
    private $client;

    /**
     * @param MySqlClient $client
     */
    public function __construct(MySqlClient $client)
    {
        $this->client = $client;
    }

    public function whenRentBookOpenedAutomatic(RentBookOpenedAutomatic $e)
    {
        $this->client
            ->query()
            ->table('rent_books')
            ->insert([
                         'id'          => $e->getRentBookId(),
                         'contract_id' => $e->getContractId(),
                         'tenant_id'   => $e->getTenantId(),
                         'rent_amount' => $e->getRentAmount()->getAmountInPounds(),
                         'opened_at'   => $e->getOpenedAt(),
                     ]);
    }

    /**
     * @param RentDueSet $e
     */
    public function whenRentBookPaymentDueSet(RentDueSet $e)
    {
        $this->client
            ->query()
            ->table('rent_book_rent')
            ->insert([
                         'id'           => $e->getRentBookRentId(),
                         'rent_book_id' => $e->getRentBookId(),
                         'due'          => $e->getPaymentDue()
                     ]);
    }

    /**
     * @return array
     */
    protected function register()
    {
        return [
            'whenRentBookOpenedAutomatic' => RentBookOpenedAutomatic::class,
            'whenRentBookPaymentDueSet'   => RentDueSet::class,
        ];
    }
}