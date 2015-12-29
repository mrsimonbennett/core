<?php
namespace FullRent\Core\Company;

use SmoothPhp\Contracts\EventSourcing\AggregateRoot;


/**
 * Interface CompanyRepository
 * @package FullRent\Core\CompanyModal
 * @author Simon Bennett <simon@bennett.im>
 */
interface CompanyRepository
{
    /**
     * @param $id
     * @return Company
     */
    public function load($id);

    /**
     * @param AggregateRoot $aggregateRoot
     * @return void
     */
    public function save(AggregateRoot $aggregateRoot);
}