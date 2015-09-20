<?php
namespace FullRent\Core\RentBook\Commands;

use FullRent\Core\QueryBus\QueryBus;
use FullRent\Core\RentBook\Queries\FindRentBookByAuthorizationIdQuery;
use FullRent\Core\RentBook\Repository\RentBookRepository;
use FullRent\Core\RentBook\ValueObjects\RentBookId;

/**
 * Class CancelRentBookBillHandler
 * @package FullRent\Core\RentBook\Commands
 * @author Simon Bennett <simon@bennett.im>
 */
final class CancelRentBookBillHandler
{
    /** @var QueryBus */
    private $queryBus;

    /** @var RentBookRepository */
    private $rentBookRepository;

    /**
     * CancelRentBookBillHandler constructor.
     * @param QueryBus $queryBus
     * @param RentBookRepository $rentBookRepository
     */
    public function __construct(QueryBus $queryBus, RentBookRepository $rentBookRepository)
    {
        $this->queryBus = $queryBus;
        $this->rentBookRepository = $rentBookRepository;
    }

    /**
     * @param CancelRentBookBill $command
     */
    public function handle(CancelRentBookBill $command)
    {
        $id = $this->queryBus->query(new FindRentBookByAuthorizationIdQuery($command->getPreAuthId()))->id;

        $rentBook = $this->rentBookRepository->load(new RentBookId($id));

        $rentBook->cancelBill($command->getBillId());

        $this->rentBookRepository->save($rentBook);
    }
}