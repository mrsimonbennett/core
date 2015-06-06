<?php
namespace FullRent\Core\QueryBus;

/**
 * Interface QueryTranslator
 * @package FullRent\Core\QueryBus
 * @author Simon Bennett <simon@bennett.im>
 */
interface QueryTranslator
{
    /**
     * @param mixed $query
     * @return string
     */
    public function toQueryHandler($query);
}