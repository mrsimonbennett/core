<?php
namespace FullRent\Core\Tenancy\Queries;

/**
 * Class FindTenancyRentBookPayment
 * @package FullRent\Core\Tenancy\Queries
 * @author Simon Bennett <simon@bennett.im>
 */
final class FindTenancyRentBookPayment
{
    private $paymentId;

    /**
     * FindTenancyRentBookPayment constructor.
     * @param $paymentId
     */
    public function __construct($paymentId)
    {
        $this->paymentId = $paymentId;
    }

    /**
     * @return mixed
     */
    public function getPaymentId()
    {
        return $this->paymentId;
    }

}