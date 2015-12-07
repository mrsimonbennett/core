<?php
namespace FullRent\Core\User;

use SmoothPhp\EventSourcing\EventSourcedRepository;

/**
 * Class SmoothUserRepository
 * @package FullRent\Core\User
 * @author Simon Bennett <simon@bennett.im>
 */
final class SmoothUserRepository extends EventSourcedRepository implements UserRepository
{

    /**
     * @return string
     */
    protected function getPrefix()
    {
        return 'user-';
    }

    protected function getAggregateType()
    {
        return User::class;
    }
}