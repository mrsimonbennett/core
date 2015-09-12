<?php
namespace FullRent\Core\User\Commands;

/**
 * Class InviteUser
 * @package FullRent\Core\User\Commands
 * @author Simon Bennett <simon@bennett.im>
 */
final class InviteUser
{
    /** @var string */
    private $userId;

    /** @var string */
    private $email;

    /**
     * @param string $userId
     * @param string $email
     */
    public function __construct($userId, $email)
    {
        $this->userId = $userId;
        $this->email = $email;
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
    public function getEmail()
    {
        return $this->email;
    }

}