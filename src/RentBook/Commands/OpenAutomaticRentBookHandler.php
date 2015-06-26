<?php
namespace FullRent\Core\RentBook\Commands;

use FullRent\Core\CommandBus\CommandHandler;
use FullRent\Core\RentBook\RentBook;
use FullRent\Core\RentBook\Repository\RentBookRepository;
use FullRent\Core\RentBook\ValueObjects\ContractId;
use FullRent\Core\RentBook\ValueObjects\RentAmount;
use FullRent\Core\RentBook\ValueObjects\RentBookId;
use FullRent\Core\RentBook\ValueObjects\TenantId;

/**
 * Class OpenAutomaticRentBookHandler
 * @package FullRent\Core\RentBook\Commands
 * @author Simon Bennett <simon@bennett.im>
 */
final class OpenAutomaticRentBookHandler implements CommandHandler
{
    /**
     * @var RentBookRepository
     */
    private $rentBookRepository;

    /**
     * @param RentBookRepository $rentBookRepository
     */
    public function __construct(RentBookRepository $rentBookRepository)
    {
        $this->rentBookRepository = $rentBookRepository;
    }

    public function handle(OpenAutomaticRentBook $command)
    {
        $rentBook = RentBook::openRentBookAutomatic(new RentBookId($command->getRentBookId()),
                                                    new ContractId($command->getContractId()),
                                                    new TenantId($command->getTenantId()),
                                                    RentAmount::fromPounds($command->getRentInPounds()),
                                                    $command->getPaymentDates());
        $this->rentBookRepository->save($rentBook);
    }
}