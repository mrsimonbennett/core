<?php namespace FullRent\Core\Tenancy\ValueObjects;

use FullRent\Core\ValueObjects\Identity\Identity;
use FullRent\Core\ValueObjects\Identity\UuidIdentity;

/**
 * Class DocumentId
 *
 * @package FullRent\Core\Tenancy\ValueObjects
 * @author  jrdn hannah <jrdn@jrdnhannah.co.uk>
 */
final class DocumentId extends UuidIdentity implements Identity
{
}