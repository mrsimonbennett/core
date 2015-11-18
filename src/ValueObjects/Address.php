<?php
namespace FullRent\Core\ValueObjects;

use SmoothPhp\Contracts\Serialization\Serializable;

/**
 * Class Address
 * @package FullRent\Core\ValueObjects
 * @author Simon Bennett <simon@bennett.im>
 */
class Address implements Serializable, \SmoothPhp\Contracts\EventSourcing\Event
{
    /**
     * @var string
     */
    private $address;
    /**
     * @var string
     */
    private $city;
    /**
     * @var string
     */
    private $county;
    /**
     * @var string
     */
    private $country;
    /**
     * @var string
     */
    private $postcode;

    /**
     * @param string $address
     * @param string $city
     * @param string $county
     * @param string $country
     * @param string $postcode
     */
    public function __construct($address, $city, $county, $country, $postcode)
    {

        $this->address = $address;
        $this->city = $city;
        $this->county = $county;
        $this->country = $country;
        $this->postcode = $postcode;
    }

    /**
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @return string
     */
    public function getCounty()
    {
        return $this->county;
    }

    /**
     * @return string
     */
    public function getPostcode()
    {
        return $this->postcode;
    }

    /**
     * @return string
     */
    public function getSingleLine()
    {
        return $this->getAddress() . ' ' . $this->getCity() . ' ' . $this->getPostcode();
    }

    /**
     * @param array $data
     * @return mixed The object instance
     */
    public static function deserialize(array $data)
    {
        return new static($data['address'], $data['city'], $data['county'], $data['country'], $data['postcode']);
    }

    /**
     * @return array
     */
    public function serialize()
    {
        return [
            'address' => $this->address,
            'city' => $this->city,
            'county' => $this->county,
            'country' => $this->country,
            'postcode' => $this->postcode
        ];
    }
}