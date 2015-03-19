<?php
namespace FullRent\Core\User\Events;

use FullRent\Core\User\ValueObjects\Email;

/**
 * Class UsersEmailHasChanged
 * @package FullRent\Core\User\Events
 * @author Simon Bennett <simon@bennett.im>
 */
final class UsersEmailHasChanged
{
    /**
     * @var Email
     */
    private $email;

    /**
     * @param Email $email
     */
    public function __construct(Email $email)
    {
        $this->email = $email;
    }

    /**
     * @return Email
     */
    public function getEmail()
    {
        return $this->email;
    }

}