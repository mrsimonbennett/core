<?php
namespace FullRent\Core\User\Queries;

/**
 * Class FindUserByEmailQuery
 * @package FullRent\Core\User\Queries
 * @author Simon Bennett <simon@bennett.im>
 */
final class FindUserByEmailQuery
{
    /** @var string */
    private $email;

    /**
     * @param string $email
     */
    public function __construct($email)
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }
}