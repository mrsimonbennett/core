<?php
namespace FullRent\Core\Services\DirectDebit\GoCardLess;

use Broadway\Serializer\SerializableInterface;

/**
 * Class PreAuthorization
 * @package FullRent\Core\Services\DirectDebit\GoCardLess
 * @author Simon Bennett <simon@bennett.im>
 */
final class PreAuthorization implements SerializableInterface
{
    private $id;

    /**
     * @param $id
     */
    public function __construct($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }


    /**
     * @param array $data
     * @return mixed The object instance
     */
    public static function deserialize(array $data)
    {
        return new static($data['id']);
    }

    /**
     * @return array
     */
    public function serialize()
    {
        return ['id' => $this->id];
    }
}