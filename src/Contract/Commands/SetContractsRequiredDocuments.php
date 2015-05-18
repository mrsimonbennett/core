<?php
namespace FullRent\Core\Contract\Commands;

/**
 * Class SetContractsRequiredDocuments
 * @package FullRent\Core\Contract\Commands
 * @author Simon Bennett <simon@bennett.im>
 */
final class SetContractsRequiredDocuments 
{
    /**
     * @var bool
     */
    private $requireId;
    /**
     * @var bool
     */
    private $requireProofOfEarnings;
    /**
     * @var null|string[]
     */
    private $extraDocuments;
    /**
     * @var string
     */
    private $contractId;

    /**
     * @param string $contractId
     * @param bool $requireId
     * @param bool $requireProofOfEarnings
     * @param string[] $extraDocuments
     */
    public function __construct($contractId,$requireId,$requireProofOfEarnings,$extraDocuments = null)
    {
        $this->requireId = $requireId;
        $this->requireProofOfEarnings = $requireProofOfEarnings;
        $this->extraDocuments = $extraDocuments;
        $this->contractId = $contractId;
    }

    /**
     * @return string
     */
    public function getContractId()
    {
        return $this->contractId;
    }

    /**
     * @return boolean
     */
    public function isRequireId()
    {
        return $this->requireId;
    }

    /**
     * @return boolean
     */
    public function isRequireProofOfEarnings()
    {
        return $this->requireProofOfEarnings;
    }

    /**
     * @return null|\string[]
     */
    public function getExtraDocuments()
    {
        return $this->extraDocuments;
    }

}