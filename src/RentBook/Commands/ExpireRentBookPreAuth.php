<?php
namespace FullRent\Core\RentBook\Commands;

use SmoothPhp\CommandBus\BaseCommand;

/**
 * Class ExpireRentBookPreAuth
 * @package FullRent\Core\RentBook\Commands
 * @author Simon Bennett <simon@bennett.im>
 */
final class ExpireRentBookPreAuth extends BaseCommand
{
    private $preAuthId;

    /**
     * ExpireRentBookPreAuth constructor.
     * @param $preAuthId
     */
    public function __construct($preAuthId)
    {
        $this->preAuthId = $preAuthId;

    }

    /**
     * @return mixed
     */
    public function getPreAuthId()
    {
        return $this->preAuthId;
    }

}