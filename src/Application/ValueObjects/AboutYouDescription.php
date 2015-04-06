<?php
namespace FullRent\Core\Application\ValueObjects;

use Broadway\Serializer\SerializableInterface;

/**
 * Class AboutYou
 * @package FullRent\Core\Application\ValueObjects
 * @author Simon Bennett <simon@bennett.im>
 */
final class AboutYouDescription implements SerializableInterface
{
    /**
     * @var string
     */
    private $aboutInformation;

    /**
     * @param string $aboutInformation
     */
    public function __construct($aboutInformation)
    {
        $this->aboutInformation = $aboutInformation;
    }

    /**
     * @return string
     */
    public function getAboutInformation()
    {
        return $this->aboutInformation;
    }
    /**
     * @param array $data
     * @return mixed The object instance
     */
    public static function deserialize(array $data)
    {
        return new static($data['aboutInformation']);
    }

    /**
     * @return array
     */
    public function serialize()
    {
        return ['aboutInformation' => $this->aboutInformation];
    }

}