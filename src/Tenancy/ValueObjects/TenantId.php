<?php
namespace FullRent\Core\Tenancy\ValueObjects;

use FullRent\Core\ValueObjects\Identity\Identity;
use FullRent\Core\ValueObjects\Identity\UuidIdentity;

/**
 * Class TenantId
 * @package FullRent\Core\Tenancy\ValueObjects
 * @author Simon Bennett <simon@bennett.im>
 */
final class TenantId extends UuidIdentity implements Identity
{

}