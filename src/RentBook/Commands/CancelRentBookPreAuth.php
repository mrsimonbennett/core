<?php
namespace FullRent\Core\RentBook\Commands;

/**
 * Class CancelRentBookPreAuth
 * @package FullRent\Core\RentBook\Commands
 * @author Simon Bennett <simon@bennett.im>
 */
final class CancelRentBookPreAuth
{
    /**
     * @var string
     */
    private $preAuthorizationId;

    /**
     * CancelRentBookPreAuth constructor.
     * @param string $preAuthorizationId
     */
    public function __construct($preAuthorizationId)
    {
        $this->preAuthorizationId = $preAuthorizationId;
    }

    /**
     * @return string
     */
    public function getPreAuthorizationId()
    {
        return $this->preAuthorizationId;
    }

}