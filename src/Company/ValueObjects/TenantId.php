<?php
namespace FullRent\Core\Company\ValueObjects;

use FullRent\Core\ValueObjects\Identity\Identity;
use FullRent\Core\ValueObjects\Identity\UuidIdentity;

/**
 * Class TenantId
 * @package FullRent\Core\Company\ValueObjects
 * @author Simon Bennett <simon@bennett.im>
 */
final class TenantId extends UuidIdentity implements Identity
{
   
}