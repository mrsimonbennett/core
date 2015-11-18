<?php
namespace FullRent\Core\RentBook\Commands;

use SmoothPhp\CommandBus\BaseCommand;

/**
 * Class CancelRentBookPreAuth
 * @package FullRent\Core\RentBook\Commands
 * @author Simon Bennett <simon@bennett.im>
 */
final class CancelRentBookPreAuth extends BaseCommand
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