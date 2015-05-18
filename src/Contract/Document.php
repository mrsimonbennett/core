<?php
namespace FullRent\Core\Contract;

use Broadway\Serializer\SerializableInterface;

/**
 * Class Document
 * @package FullRent\Core\Contract
 * @author Simon Bennett <simon@bennett.im>
 */
final class Document implements SerializableInterface
{
    /**
     * @var string
     */
    private $name;
    /**
     * @var string
     */
    private $type;

    /**
     * @param string $name
     * @param string $type
     */
    public function __construct($name, $type = "custom")
    {
        $this->name = $name;
        $this->type = $type;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }


    /**
     * @param array $data
     * @return mixed The object instance
     */
    public static function deserialize(array $data)
    {
        return new static($data['name'], $data['type']);
    }

    /**
     * @return array
     */
    public function serialize()
    {
        return ['name' => $this->name, 'type' => $this->type];
    }
}