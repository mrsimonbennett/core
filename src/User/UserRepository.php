<?php
namespace FullRent\Core\User;

use Broadway\Domain\AggregateRoot;

/**
 * Interface UserRepository
 * @package FullRent\Core\User
 * @author Simon Bennett <simon@bennett.im>
 */
interface UserRepository 
{
    /**
     * @param $id
     * @return User
     */
    public function load($id);

    /**
     * @param AggregateRoot $aggregateRoot
     * @return void
     */
    public function save(AggregateRoot $aggregateRoot);
}