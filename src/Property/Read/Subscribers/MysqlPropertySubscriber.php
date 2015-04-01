<?php
namespace FullRent\Core\Property\Read\Subscribers;

use FullRent\Core\Infrastructure\Subscribers\BaseMysqlSubscriber;
use FullRent\Core\Property\Events\NewPropertyListed;

/**
 * Class MysqlPropertySubscriber
 * @package FullRent\Core\Property\Read\Subscribers
 * @author Simon Bennett <simon@bennett.im>
 */
final class MysqlPropertySubscriber extends BaseMysqlSubscriber
{
    /**
     * @param NewPropertyListed $newPropertyListed
     */
    public function whenPropertyWasListed(NewPropertyListed $newPropertyListed)
    {
        $this->db->table('properties')->insert([]);
    }
}