<?php
namespace FullRent\Core\Application;

use SmoothPhp\Contracts\EventSourcing\AggregateRoot;

/**
 * Interface ApplicationRepository
 * @package FullRent\Core\Application
 * @author Simon Bennett <simon@bennett.im>
 */
interface ApplicationRepository 
{
    /**
     * @param $id
     * @return Application
     */
    public function load($id);

    /**
     * @param AggregateRoot $aggregateRoot
     * @return void
     */
    public function save(AggregateRoot $aggregateRoot);
}