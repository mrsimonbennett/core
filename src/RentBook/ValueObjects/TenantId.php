<?php
namespace FullRent\Core\RentBook\ValueObjects;

use FullRent\Core\ValueObjects\Identity\Identity;
use FullRent\Core\ValueObjects\Identity\UuidIdentity;

/**
 * Class TenantId
 * @package FullRent\Core\RentBook\ValueObjects
 * @author Simon Bennett <simon@bennett.im>
 */
final class TenantId extends UuidIdentity implements Identity
{

}