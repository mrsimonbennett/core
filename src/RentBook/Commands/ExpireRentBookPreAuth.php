<?php
namespace FullRent\Core\RentBook\Commands;

/**
 * Class ExpireRentBookPreAuth
 * @package FullRent\Core\RentBook\Commands
 * @author Simon Bennett <simon@bennett.im>
 */
final class ExpireRentBookPreAuth
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