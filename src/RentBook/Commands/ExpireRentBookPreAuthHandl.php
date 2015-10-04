<?php
namespace FullRent\Core\RentBook\Commands;

use FullRent\Core\QueryBus\QueryBus;
use FullRent\Core\RentBook\Queries\FindRentBookByAuthorizationIdQuery;
use FullRent\Core\RentBook\Repository\RentBookRepository;
use FullRent\Core\RentBook\ValueObjects\RentBookId;

/**
 * Class ExpireRentBookPreAuthHandler
 * @package FullRent\Core\RentBook\Commands
 * @author Simon Bennett <simon@bennett.im>
 */
final class ExpireRentBookPreAuthHandler
{
    /** @var QueryBus */
    private $queryBus;

    /** @var RentBookRepository */
    private $rentBookRepository;

    /**
     * CancelRentBookPreAuthHandler constructor.
     * @param QueryBus $queryBus
     * @param RentBookRepository $rentBookRepository
     */
    public function __construct(QueryBus $queryBus, RentBookRepository $rentBookRepository)
    {
        $this->queryBus = $queryBus;
        $this->rentBookRepository = $rentBookRepository;
    }

    public function handle(ExpireRentBookPreAuth $command)
    {
        $id = $this->queryBus->query(new FindRentBookByAuthorizationIdQuery($command->getPreAuthorizationId()))->id;


        $rentBook = $this->rentBookRepository->load(new RentBookId($id));

        $rentBook->expirePreAuth();

        $this->rentBookRepository->save($rentBook);
    }
}