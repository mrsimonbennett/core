<?php
namespace FullRent\Core\Application\ValueObjects;

use SmoothPhp\Contracts\Serialization\Serializable;

/**
 * Class RejectReason
 * @package FullRent\Core\Application\ValueObjects
 * @author Simon Bennett <simon@bennett.im>
 */
final class RejectReason implements Serializable, \SmoothPhp\Contracts\EventSourcing\Event
{
    /**
     * @var string
     */
    private $reason;

    /**
     * @param string $reason
     */
    public function __construct($reason)
    {
        \Assert\that($reason)->string();
        $this->reason = $reason;
    }

    /**
     * @return string
     */
    public function getReason()
    {
        return $this->reason;
    }

    /**
     * @param array $data
     * @return mixed The object instance
     */
    public static function deserialize(array $data)
    {
        return new static($data['reason']);
    }

    /**
     * @return array
     */
    public function serialize()
    {
        return ['reason' => $this->reason];
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string)$this->reason;
    }

}