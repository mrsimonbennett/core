<?php
namespace FullRent\Core\User\Commands;

/**
 * Class ResetUsersPassword
 * @package FullRent\Core\User\Commands
 * @author Simon Bennett <simon@bennett.im>
 */
final class ResetUsersPassword
{
    private $email;

    private $newPassword;

    private $token;

    /**
     * @param $email
     * @param $newPassword
     * @param $token
     */
    public function __construct($email, $newPassword, $token)
    {
        $this->email = $email;
        $this->newPassword = $newPassword;
        $this->token = $token;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return mixed
     */
    public function getNewPassword()
    {
        return $this->newPassword;
    }

    /**
     * @return mixed
     */
    public function getToken()
    {
        return $this->token;
    }

}