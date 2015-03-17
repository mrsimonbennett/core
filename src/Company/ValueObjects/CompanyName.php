<?php
namespace FullRent\Core\Company\ValueObjects;

/**
 * Class CompanyName\ValueObjects
 * @package FullRent\Core\Company
 * @author Simon Bennett <simon@bennett.im>
 */
final class CompanyName
{
    /**
     * @var string
     */
    private $name;

    /**
     * @param string $name
     */
    public function __construct($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

}