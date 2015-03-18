<?php
namespace FullRent\Core\Company;

use Broadway\Domain\AggregateRoot;

/**
 * Interface CompanyRepository
 * @package FullRent\Core\Company
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