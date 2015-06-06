<?php
namespace FullRent\Core\QueryBus;

/**
 * Class SimpleQueryTranslator
 * @package FullRent\Core\QueryBus
 * @author Simon Bennett <simon@bennett.im>
 */
final class SimpleQueryTranslator implements QueryTranslator
{

    /**
     * @param mixed $query
     * @return string
     */
    public function toQueryHandler($query)
    {
        return get_class($query) . 'Handler';
    }
}