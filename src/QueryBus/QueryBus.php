<?php
namespace FullRent\Core\QueryBus;

/**
 * Interface QueryBus
 * @package FullRent\Core\QueryBus
 * @author Simon Bennett <simon@bennett.im>
 */
interface QueryBus
{
    /**
     * @param $query
     * @return \stdClass
     */
    public function query($query);
}