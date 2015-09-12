<?php
namespace FullRent\Core\User\Commands;

/**
 * Class CompletedApplication
 * @package FullRent\Core\User\Commands
 * @author Simon Bennett <simon@bennett.im>
 */
final class CompletedApplication
{
    /** @var string */
    private $token;

    /** @var string */
    private $email;

    /** @var string */
    private $password;

    /** @var string */
    private $legalName;

    /** @var string */
    private $knownAs;

    /**
     * @param string $token
     * @param string $email
     * @param string $password
     * @param string $legalName
     * @param string $knownAs
     */
    public function __construct($token, $email, $password, $legalName, $knownAs)
    {
        $this->token = $token;
        $this->email = $email;
        $this->password = $password;
        $this->legalName = $legalName;
        $this->knownAs = $knownAs;
    }

    /**
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
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
