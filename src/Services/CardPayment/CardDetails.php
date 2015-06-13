<?php
namespace FullRent\Core\Services\CardPayment;

/**
 * Class CardDetails
 * @package FullRent\Core\Services\CardPayment
 * @author Simon Bennett <simon@bennett.im>
 */
class CardDetails
{
    /**
     * @var string
     */
    private $number;
    /**
     * @var string
     */
    private $expiryMonth;
    /**
     * @var string
     */
    private $expiryYear;
    /**
     * @var int
     */
    private $cvc;
    /**
     * @var string
     */
    private $name;

    /**
     * @param string $number
     * @param string $expiryMonth
     * @param string $expiryYear
     * @param int    $cvc
     * @param string $name
     */
    public function __construct($number, $expiryMonth, $expiryYear, $cvc, $name)
    {
        $this->number = $number;
        $this->expiryMonth = $expiryMonth;
        $this->expiryYear = $expiryYear;
        $this->cvc = $cvc;
        $this->name = $name;
    }

    /**
     * @return int
     */
    public function getCvc()
    {
        return $this->cvc;
    }

    /**
     * @return string
     */
    public function getExpiryMonth()
    {
        return $this->expiryMonth;
    }

    /**
     * @return string
     */
    public function getExpiryYear()
    {
        return $this->expiryYear;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * Convert to a stripe array for processing
     * @return array
     */
    public function toStripeArray()
    {
        return [
            'number'    => $this->number,
            'exp_month' => $this->expiryMonth,
            'exp_year'  => $this->expiryYear,
            'cvc'       => $this->cvc,
            'name'      => $this->name,
        ];
    }
}