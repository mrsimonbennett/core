<?php
namespace FullRent\Core\ValueObjects\Person;

/**
 * Class HashedPassword
 * @package FullRent\Core\ValueObjects\Person
 * @author Simon Bennett <simon@bennett.im>
 */
class HashedPassword
{
    /**
     * @var string
     */
    private $password;

    /**
     * @param string $password
     */
    public function __construct($password)
    {
        $this->password = $password;
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
    function __toString()
    {
        return (string)$this->password;
    }
}