<?php
namespace FullRent\Core\Deposit\Commands;

use SmoothPhp\CommandBus\BaseCommand;

/**
 * Class PayDepositWithCard
 * @package FullRent\Core\Deposit\Commands
 * @author Simon Bennett <simon@bennett.im>
 */
final class PayDepositWithCard extends BaseCommand
{
    /**
     * @var string
     */
    private $depositId;
    /**
     * @var string
     */
    private $cardName;
    /**
     * @var string
     */
    private $cardNumber;
    /**
     * @var string
     */
    private $cardExpiresDate;
    /**
     * @var string
     */
    private $cardCvs;

    /**
     * @param string $depositId
     * @param string $cardName
     * @param string $cardNumber
     * @param string $cardExpiresDate
     * @param string $cardCvs
     */
    public function __construct($depositId, $cardName, $cardNumber, $cardExpiresDate, $cardCvs)
    {
        $this->depositId = $depositId;
        $this->cardName = $cardName;
        $this->cardNumber = $cardNumber;
        $this->cardExpiresDate = $cardExpiresDate;
        $this->cardCvs = $cardCvs;


    }

    /**
     * @return string
     */
    public function getDepositId()
    {
        return $this->depositId;
    }

    /**
     * @return string
     */
    public function getCardName()
    {
        return $this->cardName;
    }

    /**
     * @return string
     */
    public function getCardNumber()
    {
        return $this->cardNumber;
    }

    /**
     * @return string
     */
    public function getCardExpiresDate()
    {
        return $this->cardExpiresDate;
    }

    /**
     * @return string
     */
    public function getCardCvs()
    {
        return $this->cardCvs;
    }

}