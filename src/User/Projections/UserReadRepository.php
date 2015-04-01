<?php
namespace FullRent\Core\User\Projections;

use FullRent\Core\User\Exceptions\UserNotFoundException;
use FullRent\Core\User\ValueObjects\Email;
use FullRent\Core\User\ValueObjects\UserId;
use stdClass;

/**
 * Interface UserRepository
 * @package FullRent\Core\User\Projections
 * @author Simon Bennett <simon@bennett.im>
 */
interface UserReadRepository
{
    /**
     * @param Email $email
     * @return stdClass
     * @throws UserNotFoundException
     */
    public function getByEmail(Email $email);

    /**
     * @param UserId $userId
     * @return stdClass
     * @throws UserNotFoundException
     */
    public function getById(UserId $userId);
}