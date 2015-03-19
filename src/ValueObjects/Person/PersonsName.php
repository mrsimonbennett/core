<?php
namespace FullRent\Core\ValueObjects\Person;

/**
 * Class PersonsName
 * @package FullRent\Core\ValueObjects\Person
 * @author Simon Bennett <simon@bennett.im>
 */
class PersonsName
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

}