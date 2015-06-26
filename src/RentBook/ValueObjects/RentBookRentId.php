<?php
namespace FullRent\Core\RentBook\ValueObjects;

use FullRent\Core\ValueObjects\Identity\Identity;
use FullRent\Core\ValueObjects\Identity\UuidIdentity;

/**
 * Class RentBookRentId
 * @package FullRent\Core\RentBook\ValueObjects
 * @author Simon Bennett <simon@bennett.im>
 */
final class RentBookRentId extends UuidIdentity implements Identity
{

}