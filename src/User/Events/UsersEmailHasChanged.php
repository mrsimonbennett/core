<?php
namespace FullRent\Core\User\Events;

use FullRent\Core\User\ValueObjects\Email;
use SmoothPhp\Contracts\Serialization\Serializable;

/**
 * Class UsersEmailHasChanged
 * @package FullRent\Core\User\Events
 * @author Simon Bennett <simon@bennett.im>
 */
final class UsersEmailHasChanged implements Serializable, \SmoothPhp\Contracts\EventSourcing\Event
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

    /**
     * @return array
     */
    public function serialize()
    {
        throw new \Exception('Not implemented [serialize] method');
    }

    /**
     * @param array $data
     * @return static
     */
    public static function deserialize(array $data)
    {
        throw new \Exception('Not implemented [deserialize] method');
    }
}