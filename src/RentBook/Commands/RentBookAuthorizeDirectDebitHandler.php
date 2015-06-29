<?php
namespace FullRent\Core\RentBook\Commands;

use FullRent\Core\RentBook\Repository\RentBookRepository;
use FullRent\Core\RentBook\ValueObjects\RentBookId;
use FullRent\Core\Services\DirectDebit\DirectDebit;
use FullRent\Core\Services\DirectDebit\DirectDebitAccountAuthorisation;

/**
 * Class RentBookAuthorizeDirectDebitHandler
 * @package FullRent\Core\RentBook\Commands
 * @author Simon Bennett <simon@bennett.im>
 */
final class RentBookAuthorizeDirectDebitHandler
{
    /**
     * @var RentBookRepository
     */
    private $rentBookRepository;
    /**
     * @var DirectDebitAccountAuthorisation
     */
    private $directDebit;

    /**
     * @param RentBookRepository $rentBookRepository
     * @param DirectDebit $directDebit
     */
    public function __construct(
        RentBookRepository $rentBookRepository,
        DirectDebit $directDebit
    ) {
        $this->rentBookRepository = $rentBookRepository;
        $this->directDebit = $directDebit;
    }

    public function handle(RentBookAuthorizeDirectDebit $command)
    {
        $rentBook = $this->rentBookRepository->load(new RentBookId($command->getRentBookId()));

        $rentBook->authorizeDirectDebit($this->directDebit,
                                        $command->getResourceId(),
                                        $command->getResourceType(),
                                        $command->getResourceUri(),
                                        $command->getSignature(), $command->getAccessTokens());

        $this->rentBookRepository->save($rentBook);
    }
}