<?php
namespace FullRent\Core\Projections\Properties\Queries;

/**
 * Class FindPropertiesByCompany
 * @package FullRent\Core\Projections\Properties\Queries
 * @author Simon Bennett <simon@bennett.im>
 */
final class FindPropertiesByCompany
{
    private $companyId;

    /**
     * FindPropertiesByCompany constructor.
     * @param $companyId
     */
    public function __construct($companyId)
    {
        $this->companyId = $companyId;
    }

    /**
     * @return mixed
     */
    public function getCompanyId()
    {
        return $this->companyId;
    }

}