<?php
namespace FullRent\Core\User\Commands;

use SmoothPhp\CommandBus\BaseCommand;

/**
 * Class ResetUsersPasswordRequest
 * @package FullRent\Core\User\Commands
 * @author Simon Bennett <simon@bennett.im>
 */
final class ResetUsersPasswordRequest extends BaseCommand
{
    /** @var string */
    private $email;

    /**
     * @param string $email
     */
    public function __construct($email)
    {
        $this->email = $email;
        parent::__construct();
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }
    
}