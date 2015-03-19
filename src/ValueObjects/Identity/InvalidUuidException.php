<?php
namespace FullRent\Core\ValueObjects\Identity;
use InvalidArgumentException;

/**
 * Class InvalidUuidException
 * @package Discuss
 * @author  Simon Bennett <simon@bennett.im>
 */
final class InvalidUuidException extends InvalidArgumentException
{
    /**
     * @param string $invalidUuid
     */
    public function __construct($invalidUuid)
    {
        $this->message = "UUID [{$invalidUuid}] is not a valid UUID";
    }
}