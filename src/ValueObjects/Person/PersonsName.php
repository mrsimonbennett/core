<?php
namespace FullRent\Core\ValueObjects\Person;

use Broadway\Serializer\SerializableInterface;

/**
 * Class PersonsName
 * @package FullRent\Core\ValueObjects\Person
 * @author Simon Bennett <simon@bennett.im>
 */
class PersonsName implements SerializableInterface
{
    /**
     * @var string
     */
    private $legalName;
    /**
     * @var string
     */
    private $knowAs;

    /**
     * @param string $legalName
     * @param string $knowAs
     */
    public function __construct($legalName, $knowAs)
    {
        $this->legalName = $legalName;
        $this->knowAs = $knowAs;
    }

    /**
     * @return string
     */
    public function getLegalName()
    {
        return $this->legalName;
    }

    /**
     * @return string
     */
    public function getKnowAs()
    {
        return $this->knowAs;
    }

    /**
     * @param array $data
     * @return mixed The object instance
     */
    public static function deserialize(array $data)
    {
        return new static($data['legal-name'], $data['know-as']);
    }

    /**
     * @return array
     */
    public function serialize()
    {
        return ['legal-name' => $this->legalName, 'know-as' => $this->knowAs];
    }
}