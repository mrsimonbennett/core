<?php
namespace FullRent\Core\Application\ValueObjects;

use Broadway\Serializer\SerializableInterface;

/**
 * Class AboutYouApplication
 * @package FullRent\Core\Application\ValueObjects
 * @author Simon Bennett <simon@bennett.im>
 */
final class AboutYouApplication implements SerializableInterface
{
    /**
     * @var AboutYouDescription
     */
    private $aboutYou;
    /**
     * @var DateOfBirth
     */
    private $dateOfBirth;
    /**
     * @var PhoneNumber
     */
    private $phoneNumber;

    /**
     * @param AboutYouDescription $aboutYou
     * @param DateOfBirth $dateOfBirth
     * @param PhoneNumber $phoneNumber
     */
    public function __construct(AboutYouDescription $aboutYou, DateOfBirth $dateOfBirth, PhoneNumber $phoneNumber)
    {

        $this->aboutYou = $aboutYou;
        $this->dateOfBirth = $dateOfBirth;
        $this->phoneNumber = $phoneNumber;
    }

    /**
     * @return AboutYouDescription
     */
    public function getAboutYou()
    {
        return $this->aboutYou;
    }

    /**
     * @return DateOfBirth
     */
    public function getDateOfBirth()
    {
        return $this->dateOfBirth;
    }

    /**
     * @return PhoneNumber
     */
    public function getPhoneNumber()
    {
        return $this->phoneNumber;
    }

    /**
     * @param array $data
     * @return mixed The object instance
     */
    public static function deserialize(array $data)
    {
        return new static(AboutYouDescription::deserialize($data['about_you']),
                          DateOfBirth::deserialize($data['date_of_birth']),
                          PhoneNumber::deserialize($data['phone']));
    }

    /**
     * @return array
     */
    public function serialize()
    {
        return [
            'about_you'     => $this->aboutYou->serialize(),
            'date_of_birth' => $this->dateOfBirth->serialize(),
            'phone'         => $this->phoneNumber->serialize()
        ];
    }
}