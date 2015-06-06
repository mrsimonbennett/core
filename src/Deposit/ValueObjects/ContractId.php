<?php
namespace FullRent\Core\Deposit\ValueObjects;

use FullRent\Core\ValueObjects\Identity\Identity;
use FullRent\Core\ValueObjects\Identity\UuidIdentity;

/**
 * Class ContractId
 * @package FullRent\Core\Deposit\ValueObjects
 * @author Simon Bennett <simon@bennett.im>
 */
final class ContractId extends UuidIdentity implements Identity
{

}