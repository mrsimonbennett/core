<?php
namespace FullRent\Core\Tenancy\Queries;

/**
 * Class FindTenancyByCompanyId
 * @package FullRent\Core\Tenancy\Queries
 * @author Simon Bennett <simon@bennett.im>
 */
final class FindTenancyByCompanyId
{
    private $companyId;

    /**
     * FindTenancyByCompanyId constructor.
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