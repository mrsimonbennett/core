<?php
namespace FullRent\Core\Contract\Query;

/**
 * Class FindContractByIdQuery
 * @package FullRent\Core\Contract\Query
 * @author Simon Bennett <simon@bennett.im>
 */
final class FindContractByIdQuery
{
    /**
     * @var string
     */
    private $contractId;

    /**
     * @param string $contractId
     */
    public function __construct($contractId)
    {
        $this->contractId = $contractId;
    }

    /**
     * @return string
     */
    public function getContractId()
    {
        return $this->contractId;
    }

}