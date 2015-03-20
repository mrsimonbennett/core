<?php
namespace FullRent\Core\ValueObjects\Person;

use Broadway\Serializer\SerializableInterface;

/**
 * Class HashedPassword
 * @package FullRent\Core\ValueObjects\Person
 * @author Simon Bennett <simon@bennett.im>
 */
class HashedPassword implements SerializableInterface
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
    public function __toString()
    {
        return (string)$this->password;
    }

    /**
     * @param array $data
     * @return mixed The object instance
     */
    public static function deserialize(array $data)
    {
        return new static($data['hash']);
    }

    /**
     * @return array
     */
    public function serialize()
    {
        return ['hash' => $this->password];
    }
}