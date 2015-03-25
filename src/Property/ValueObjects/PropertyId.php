<?php
namespace FullRent\Core\Property\ValueObjects;

use FullRent\Core\ValueObjects\Identity\Identity;
use FullRent\Core\ValueObjects\Identity\UuidIdentity;

/**
 * Class PropertyId
 * @package FullRent\Core\Property\ValueObjects
 * @author Simon Bennett <simon@bennett.im>
 */
final class PropertyId extends UuidIdentity implements Identity
{

}