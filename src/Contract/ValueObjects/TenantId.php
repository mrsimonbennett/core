<?php
namespace FullRent\Core\Contract\ValueObjects;

use FullRent\Core\ValueObjects\Identity\Identity;
use FullRent\Core\ValueObjects\Identity\UuidIdentity;

/**
 * Class TenantId
 * @package FullRent\Core\Contract\ValueObjects
 * @author Simon Bennett <simon@bennett.im>
 */
final class TenantId extends UuidIdentity implements Identity
{
   
}