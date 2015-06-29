<?php
namespace FullRent\Core\RentBook\Commands;

use FullRent\Core\RentBook\Repository\RentBookRepository;
use FullRent\Core\RentBook\ValueObjects\RentBookId;
use FullRent\Core\Services\DirectDebit\DirectDebit;

/**
 * Class RentBookCreateBillsHandler
 * @package FullRent\Core\RentBook\Commands
 * @author Simon Bennett <simon@bennett.im>
 */
final class RentBookCreateBillsHandler
{
    /**
     * @var RentBookRepository
     */
    private $rentBookRepository;
    /**
     * @var DirectDebit
     */
    private $directDebit;

    /**
     * @param RentBookRepository $rentBookRepository
     */
    public function __construct(RentBookRepository $rentBookRepository, DirectDebit $directDebit)
    {
        $this->rentBookRepository = $rentBookRepository;
        $this->directDebit = $directDebit;
    }

    /**
     * @param RentBookCreateBills $command
     */
    public function handle(RentBookCreateBills $command)
    {
        $rentBook = $this->rentBookRepository->load(new RentBookId($command->getRentBookId()));

        $rentBook->createBills($this->directDebit, $command->getAccessTokens());

        $this->rentBookRepository->save($rentBook);
    }
}