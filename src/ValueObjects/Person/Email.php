<?php
namespace FullRent\Core\ValueObjects\Person;

/**
 * Class Email
 * @package FullRent\Core\ValueObjects\Person
 * @author Simon Bennett <simon@bennett.im>
 */
final class Email 
{
    /**
     * @var string
     */
    private $email;

    /**
     * @param string $email
     */
    public function __construct($email)
    {
        $this->guardAgainstInvalidEmailAddresses($email);

        $this->email = $email;
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
    public function __toString()
    {
        return (string) $this->email;
    }

    /**
     * @param string $email
     */
    private function guardAgainstInvalidEmailAddresses($email)
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new \InvalidArgumentException("Email [{$email}] is not a valid email");
        }
    }

    /**
     * @param Email $other
     * @return bool
     */
    public function equal(Email $other)
    {
        return $this->email === $other->getEmail();
    }
}