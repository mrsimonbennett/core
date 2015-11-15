<?php
namespace FullRent\Core\User\Queries;

/**
 * Class FindCompanyLandlord
 * @package FullRent\Core\User\Queries
 * @author Simon Bennett <simon@bennett.im>
 */
final class FindCompanyLandlord
{
    private $companyId;

    /**
     * FindCompanyLandlord constructor.
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