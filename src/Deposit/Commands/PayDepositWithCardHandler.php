<?php
namespace FullRent\Core\Deposit\Commands;

use FullRent\Core\Deposit\Repository\DepositRepository;
use FullRent\Core\Deposit\ValueObjects\CardDetails;
use FullRent\Core\Deposit\ValueObjects\DepositId;
use FullRent\Core\Services\CardPayment\CardPaymentGateway;

/**
 * Class PayDepositWithCardHandler
 * @package FullRent\Core\Deposit\Commands
 * @author Simon Bennett <simon@bennett.im>
 */
final class PayDepositWithCardHandler
{
    /**
     * @var DepositRepository
     */
    private $depositRepository;
    /**
     * @var CardPaymentGateway
     */
    private $cardPaymentGateway;

    /**
     * @param DepositRepository $depositRepository
     * @param CardPaymentGateway $cardPaymentGateway
     */
    public function __construct(DepositRepository $depositRepository, CardPaymentGateway $cardPaymentGateway)
    {
        $this->depositRepository = $depositRepository;
        $this->cardPaymentGateway = $cardPaymentGateway;
    }

    public function handle(PayDepositWithCard $command)
    {
        $deposit = $this->depositRepository->load(new DepositId($command->getDepositId()));


        $deposit->fullPayment(
            new CardDetails('4242424242424242', 10, 2016, 123, 'Mr Simon Benentt'),
            $this->cardPaymentGateway);

        $this->depositRepository->save($deposit);
    }
}