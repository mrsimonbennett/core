<?php
namespace FullRent\Core\Tenancy\ValueObjects;

use SmoothPhp\Contracts\Serialization\Serializable;

/**
 * Class RentDetails
 * @package FullRent\Core\Tenancy\ValueObjects
 * @author Simon Bennett <simon@bennett.im>
 */
final class RentDetails implements Serializable
{
    /** @var RentAmount */
    private $rentAmount;

    /** @var RentFrequency */
    private $rentFrequency;

    /**
     * RentDetails constructor.
     * @param RentAmount $rentAmount
     * @param RentFrequency $rentFrequency
     */
    public function __construct(RentAmount $rentAmount, RentFrequency $rentFrequency)
    {
        $this->rentAmount = $rentAmount;
        $this->rentFrequency = $rentFrequency;
    }

    /**
     * @return RentAmount
     */
    public function getRentAmount()
    {
        return $this->rentAmount;
    }

    /**
     * @return RentFrequency
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
        return [
            'rent_amount'    => $this->rentAmount->serialize(),
            'rent_frequency' => $this->rentFrequency->serialize(),
        ];
    }

    /**
     * @param array $data
     * @return static
     */
    public static function deserialize(array $data)
    {
        return new static(RentAmount::deserialize($data['rent_amount']),
                          RentFrequency::deserialize($data['rent_frequency']));
    }
}