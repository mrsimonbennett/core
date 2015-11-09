<?php
namespace FullRent\Core\ValueObjects;

use SmoothPhp\Contracts\Serialization\Serializable;
use Carbon\Carbon;

/**
 * Class DateTime
 * @package FullRent\Core\ValueObjects
 * @author Simon Bennett <simon@bennett.im>
 */
final class DateTime extends Carbon implements Serializable, \SmoothPhp\Contracts\EventSourcing\Event
{

    /**
     * @param array $data
     * @return mixed The object instance
     */
    public static function deserialize(array $data)
    {
        return new DateTime($data['datetime']);
    }

    /**
     * @return array
     */
    public function serialize()
    {
        return ['datetime' => (string)$this];
    }
}