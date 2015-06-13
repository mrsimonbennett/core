<?php
namespace FullRent\Core\Deposit\Queries;

/**
 * Class FindAllDepositInformationForContractQuery
 * @package FullRent\Core\Deposit\Queries
 * @author Simon Bennett <simon@bennett.im>
 */
final class FindAllDepositInformationForContractQuery
{
    private $contractId;

    /**
     * @param $contractId
     */
    public function __construct($contractId)
    {
        $this->contractId = $contractId;
    }

    /**
     * @return mixed
     */
    public function getContractId()
    {
        return $this->contractId;
    }

}