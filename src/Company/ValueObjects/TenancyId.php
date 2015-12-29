<?php
namespace FullRent\Core\Company\ValueObjects;

use FullRent\Core\ValueObjects\Identity\Identity;
use FullRent\Core\ValueObjects\Identity\UuidIdentity;

/**
 * Class TenancyId
 * @package FullRent\Core\CompanyModal\ValueObjects
 * @author Simon Bennett <simon@bennett.im>
 */
final class TenancyId extends UuidIdentity implements Identity
{

}