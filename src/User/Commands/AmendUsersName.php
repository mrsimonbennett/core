<?php
namespace FullRent\Core\User\Commands;

use SmoothPhp\CommandBus\BaseCommand;

/**
 * Class AmendUsersName
 * @package FullRent\Core\User\Commands
 * @author Simon Bennett <simon@bennett.im>
 */
final class AmendUsersName extends BaseCommand
{
    /** @var string */
    private $userId;

    /** @var string */
    private $legalName;

    /** @var string */
    private $knownAs;

    /**
     * AmendUsersName constructor.
     * @param string $userId
     * @param string $legalName
     * @param string $knownAs
     */
    public function __construct($userId, $legalName, $knownAs)
    {
        $this->userId = $userId;
        $this->legalName = $legalName;
        $this->knownAs = $knownAs;

    }

    /**
     * @return string
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @return string
     */
    public function getLegalName()
    {
        return $this->legalName;
    }

    /**
     * @return string
     */
    public function getKnownAs()
    {
        return $this->knownAs;
    }

}