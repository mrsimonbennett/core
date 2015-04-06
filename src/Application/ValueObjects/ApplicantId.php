<?php
namespace FullRent\Core\Application\ValueObjects;

use FullRent\Core\ValueObjects\Identity\Identity;
use FullRent\Core\ValueObjects\Identity\UuidIdentity;

/**
 * Class ApplicantId
 * @package FullRent\Core\Application\ValueObjects
 * @author Simon Bennett <simon@bennett.im>
 */
final class ApplicantId  extends UuidIdentity implements Identity
{
   
}