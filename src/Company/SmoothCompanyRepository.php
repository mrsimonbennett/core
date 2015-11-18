<?php
namespace FullRent\Core\Company;

use SmoothPhp\EventSourcing\EventSourcedRepository;

/**
 * Class SmoothCompanyRepository
 * @package FullRent\Core\Company
 * @author Simon Bennett <simon@bennett.im>
 */
final class SmoothCompanyRepository extends EventSourcedRepository implements CompanyRepository
{

    /**
     * @return string
     */
    protected function getPrefix()
    {
        return 'company-';
    }

    protected function getAggregateType()
    {
        return Company::class;
    }
}