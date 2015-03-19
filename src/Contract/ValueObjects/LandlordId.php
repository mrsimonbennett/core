<?php
namespace FullRent\Core\Contract\ValueObjects;

use FullRent\Core\ValueObjects\Identity\Identity;
use FullRent\Core\ValueObjects\Identity\UuidIdentity;

final class LandlordId extends UuidIdentity implements Identity
{

}