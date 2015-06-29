<?php
namespace FullRent\Core\RentBook\Queries;

/**
 * Class FindRentBookQuery
 * @package FullRent\Core\RentBook\Queries
 * @author Simon Bennett <simon@bennett.im>
 */
final class FindRentBookQuery
{
    private $contractId;
    private $tenantId;

    /**
     * @param $contractId
     * @param $tenantId
     */
    public function __construct($contractId, $tenantId)
    {
        $this->contractId = $contractId;
        $this->tenantId = $tenantId;
    }

    /**
     * @return mixed
     */
    public function getContractId()
    {
        return $this->contractId;
    }

    /**
     * @return mixed
     */
    public function getTenantId()
    {
        return $this->tenantId;
    }

}