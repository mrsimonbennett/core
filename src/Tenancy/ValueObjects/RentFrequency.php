<?php
namespace FullRent\Core\Tenancy\ValueObjects;

use SmoothPhp\Contracts\Serialization\Serializable;

/**
 * Class RentFrequency
 * @package FullRent\Core\Tenancy\ValueObjects
 * @author Simon Bennett <simon@bennett.im>
 */
final class RentFrequency implements Serializable
{
    private $allowedValues = [
        '2-week',
        '4-week',
        '1-month',
        '2-month',
        '3-month',
        '4-month',
        '6-month',
        '1-year',
        'irregular',
    ];

    private $rentFrequency;

    /**
     * RentFrequency constructor.
     * @param $rentFrequency
     */
    public function __construct($rentFrequency)
    {
        if (!in_array($rentFrequency, $this->allowedValues)) {
            throw new \InvalidArgumentException('Rent Frequency Not Valid');
        }

        $this->rentFrequency = $rentFrequency;
    }

    /**
     * @return mixed
     */
    public function getRentFrequency()
    {
        return $this->rentFrequency;
    }

    /**
     * @return array
     */
    public function serialize()
    {
        return ['rent_frequency' => $this->rentFrequency];
    }

    /**
     * @param array $data
     * @return static
     */
    public static function deserialize(array $data)
    {
        return new static($data['rent_frequency']);
    }
}