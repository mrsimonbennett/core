<?php
namespace FullRent\Core\Tenancy\Queries;

/**
 * Class FindTenancyById
 * @package FullRent\Core\Tenancy\Queries
 * @author Simon Bennett <simon@bennett.im>
 */
final class FindTenancyById
{
    private $tenancyId;

    /**
     * FindTenancyById constructor.
     * @param $tenancyId
     */
    public function __construct($tenancyId)
    {
        $this->tenancyId = $tenancyId;
    }

    /**
     * @return mixed
     */
    public function getTenancyId()
    {
        return $this->tenancyId;
    }
    

}