<?php
namespace FullRent\Core\Company\ValueObjects;

use FullRent\Core\ValueObjects\Identity\Identity;
use FullRent\Core\ValueObjects\Identity\UuidIdentity;

/**
 * Class CompanyId
 * @package FullRent\Core\CompanyModal\ValueObjects
 * @author Simon Bennett <simon@bennett.im>
 */
final class CompanyId extends UuidIdentity implements Identity
{

}