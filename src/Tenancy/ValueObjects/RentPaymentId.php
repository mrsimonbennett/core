<?php
namespace FullRent\Core\Tenancy\ValueObjects;

use FullRent\Core\ValueObjects\Identity\Identity;
use FullRent\Core\ValueObjects\Identity\UuidIdentity;

/**
 * Class RentPaymentId
 * @package FullRent\Core\Tenancy\ValueObjects
 * @author Simon Bennett <simon@bennett.im>
 */
final class RentPaymentId extends UuidIdentity implements Identity
{

}