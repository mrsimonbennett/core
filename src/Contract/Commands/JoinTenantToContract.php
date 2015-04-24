<?php
namespace FullRent\Core\Contract\Commands;

/**
 * Class JoinTenantToContract
 * @package FullRent\Core\Contract\Commands
 * @author Simon Bennett <simon@bennett.im>
 */
final class JoinTenantToContract
{
    /**
     * @var string
     */
    private $contractId;
    /**
     * @var string
     */
    private $tenantId;

    /**
     * @param string $contractId
     * @param string $tenantId
     */
    public function __construct($contractId, $tenantId)
    {
        $this->contractId = $contractId;
        $this->tenantId = $tenantId;
    }

    /**
     * @return string
     */
    public function getContractId()
    {
        return $this->contractId;
    }

    /**
     * @return string
     */
    public function getTenantId()
    {
        return $this->tenantId;
    }

}