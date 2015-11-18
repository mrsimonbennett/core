<?php
namespace FullRent\Core\Application\ValueObjects;

use SmoothPhp\Contracts\Serialization\Serializable;

/**
 * Class DateOfBirth
 * @package FullRent\Core\Application\ValueObjects
 * @author Simon Bennett <simon@bennett.im>
 */
final class DateOfBirth implements Serializable, \SmoothPhp\Contracts\EventSourcing\Event
{
    /**
     * @var string
     */
    private $dateOfBirth;

    /**
     * @param string $dataOfBirth
     */
    public function __construct($dataOfBirth)
    {
        $this->dateOfBirth = $dataOfBirth;
    }

    /**
     * @return string
     */
    public function getDateOfBirth()
    {
        return $this->dateOfBirth;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string)$this->dateOfBirth;
    }

    /**
     * @param array $data
     * @return mixed The object instance
     */
    public static function deserialize(array $data)
    {
        return new static($data['dateOfBirth']);
    }

    /**
     * @return array
     */
    public function serialize()
    {
        return ['dateOfBirth' => $this->dateOfBirth];
    }
}