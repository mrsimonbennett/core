<?php
namespace FullRent\Core\Tenancy\ValueObjects;

use FullRent\Core\ValueObjects\DateTime;
use SmoothPhp\Contracts\Serialization\Serializable;

/**
 * Class TenancyDuration
 * @package FullRent\Core\Tenancy\ValueObjects
 * @author Simon Bennett <simon@bennett.im>
 */
final class TenancyDuration implements Serializable
{
    /** @var DateTime */
    private $start;

    /** @var DateTime */
    private $end;

    /**
     * TenancyDuration constructor.
     * @param DateTime $start
     * @param DateTime $end
     */
    public function __construct(DateTime $start, DateTime $end)
    {
        if ($end < $start) {
            throw  new \InvalidArgumentException("Tenancy Duration ends before it starts");
        }

        $this->start = $start;
        $this->end = $end;
    }

    /**
     * @return DateTime
     */
    public function getStart()
    {
        return $this->start;
    }

    /**
     * @return DateTime
     */
    public function getEnd()
    {
        return $this->end;
    }

    /**
     * @return array
     */
    public function serialize()
    {
        return [
            'start' => $this->start->serialize(),
            'end'   => $this->end->serialize()
        ];
    }

    /**
     * @param array $data
     * @return static
     */
    public static function deserialize(array $data)
    {
        return new static(DateTime::deserialize($data['start']), DateTime::deserialize($data['end']));
    }
}