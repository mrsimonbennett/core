<?php
namespace FullRent\Core\User\Projections;

use FullRent\Core\User\Exceptions\UserNotFound;
use FullRent\Core\User\ValueObjects\Email;
use FullRent\Core\User\ValueObjects\UserId;
use stdClass;

/**
 * Interface UserRepository
 * @package FullRent\Core\User\Projections
 * @deprecated Please use the query bus
 * @author Simon Bennett <simon@bennett.im>
 */
interface UserReadRepository
{
    /**
     * @param Email $email
     * @return stdClass
     * @throws UserNotFound
     */
    public function getByEmail(Email $email);

    /**
     * @param UserId $userId
     * @return stdClass
     * @throws UserNotFound
     */
    public function getById(UserId $userId);
}