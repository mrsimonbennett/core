<?php
namespace FullRent\Core\User\ValueObjects;

/**
 * Class PasswordResetToken
 * @package FullRent\Core\User\ValueObjects
 * @author Simon Bennett <simon@bennett.im>
 */
final class PasswordResetToken
{
    /**
     * @var string
     */
    private $code;

    /**
     * @param string $code
     */
    public function __construct($code)
    {
        $this->code = $code;
    }

    /**
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param string $seed
     * @return static
     */
    public static function random($seed)
    {
        return new static(hash_hmac('sha256', str_random(40), (string)$seed));
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string)$this->code;
    }


    /**
     * @param array $data
     * @return static The object instance
     */
    public static function deserialize(array $data)
    {
        return new static($data['code']);
    }

    /**
     * @return array
     */
    public function serialize()
    {
        return ['code' => $this->code];
    }

    /**
     * @param PasswordResetToken $passwordResetToken
     * @return bool
     */
    public function equals(PasswordResetToken $passwordResetToken)
    {
        return $this->getCode() === $passwordResetToken->getCode();
    }
}