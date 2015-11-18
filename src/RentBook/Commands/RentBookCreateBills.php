<?php
namespace FullRent\Core\RentBook\Commands;

use FullRent\Core\Services\DirectDebit\AccessTokens;
use SmoothPhp\CommandBus\BaseCommand;

/**
 * Class RentBookCreateBills
 * @package FullRent\Core\RentBook\Commands
 * @author Simon Bennett <simon@bennett.im>
 */
final class RentBookCreateBills extends BaseCommand
{
    private $rentBookId;
    /**
     * @var AccessTokens
     */
    private $accessTokens;

    /**
     * @param $rentBookId
     */
    public function __construct($rentBookId, AccessTokens $accessTokens
    )
    {
        $this->rentBookId = $rentBookId;
        $this->accessTokens = $accessTokens;
        parent::__construct();
    }

    /**
     * @return mixed
     */
    public function getRentBookId()
    {
        return $this->rentBookId;
    }

    /**
     * @return AccessTokens
     */
    public function getAccessTokens()
    {
        return $this->accessTokens;
    }


}