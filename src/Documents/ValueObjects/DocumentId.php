<?php namespace FullRent\Core\Documents\ValueObjects;

use FullRent\Core\ValueObjects\Identity\Identity;
use FullRent\Core\ValueObjects\Identity\UuidIdentity;

/**
 * Class DocumentId
 *
 * @package FullRent\Core\Deposit\ValueObjects
 * @author  Simon Bennett <simon@bennett.im>
 */
final class DocumentId extends UuidIdentity implements Identity
{
}