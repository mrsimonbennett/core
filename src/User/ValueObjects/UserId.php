<?php
namespace FullRent\Core\User\ValueObjects;

use FullRent\Core\ValueObjects\Identity\Identity;
use FullRent\Core\ValueObjects\Identity\UuidIdentity;

/**
 * Class UserId
 * @package FullRent\Core\User\ValueObjects
 * @author Simon Bennett <simon@bennett.im>
 */
final class UserId extends UuidIdentity implements Identity
{
   
}