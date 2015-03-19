<?php
namespace FullRent\Core\Contract\ValueObjects;

use FullRent\Core\ValueObjects\Identity\Identity;
use FullRent\Core\ValueObjects\Identity\UuidIdentity;

final class ContractId extends UuidIdentity implements Identity
{
   
}