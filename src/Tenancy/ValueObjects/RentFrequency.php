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
    /** @var array */
    private $allowedValues = [
        '2-week'    => 'Two Weekly',
        '4-week'    => 'Four Weekly',
        '1-month'   => 'Monthly',
        '2-month'   => '2 Months',
        '3-month'   => '3 Months',
        '4-month'   => '4 Months',
        '6-month'   => '6 Months',
        '1-year'    => 'Annually',
        'irregular' => 'Irregular Payments'
    ];

    /** @var */
    private $rentFrequency;

    /**
     * RentFrequency constructor.
     * @param $rentFrequency
     */
    public function __construct($rentFrequency)
    {
        if (!isset($this->allowedValues[$rentFrequency])) {
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
     * @return mixed
     */
    public function getRentFrequencyFormatted()
    {
        return $this->allowedValues[$this->rentFrequency];
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