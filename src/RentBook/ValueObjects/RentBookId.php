<?php
namespace FullRent\Core\RentBook\ValueObjects;

use FullRent\Core\ValueObjects\Identity\Identity;
use FullRent\Core\ValueObjects\Identity\UuidIdentity;

/**
 * Class RentBookId
 * @package FullRent\Core\RentBook\ValueObjects
 * @author Simon Bennett <simon@bennett.im>
 */
final class RentBookId extends UuidIdentity implements Identity
{

}