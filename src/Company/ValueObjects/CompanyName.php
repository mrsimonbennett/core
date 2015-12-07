<?php
namespace FullRent\Core\Company\ValueObjects;

use SmoothPhp\Contracts\Serialization\Serializable;

/**
 * Class CompanyName\ValueObjects
 * @package FullRent\Core\Company
 * @author Simon Bennett <simon@bennett.im>
 */
final class CompanyName implements Serializable, \SmoothPhp\Contracts\EventSourcing\Event
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

    /**
     * @return mixed The object instance
     */
    public static function deserialize(array $data)
    {
        return new static($data['name']);
    }

    /**
     * @return array
     */
    public function serialize()
    {
        return ['name' => $this->name];
    }
}