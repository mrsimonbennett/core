<?php
namespace FullRent\Core\Tenancy\Commands;

/**
 * Class SetTenancyToCollectRentWithDirectDebit
 * @package FullRent\Core\Tenancy\Commands
 * @author Simon Bennett <simon@bennett.im>
 */
final class SetTenancyToCollectRentWithDirectDebit
{
    private $tenancyId;

    /**
     * SetTenancyToCollectRentWithDirectDebit constructor.
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