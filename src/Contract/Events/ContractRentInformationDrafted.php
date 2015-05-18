<?php
namespace FullRent\Core\Contract\Events;

use Broadway\Serializer\SerializableInterface;
use FullRent\Core\Contract\ValueObjects\ContractId;
use FullRent\Core\Contract\ValueObjects\Deposit;
use FullRent\Core\Contract\ValueObjects\Rent;
use FullRent\Core\ValueObjects\DateTime;

/**
 * Class ContractRentInformationDrafted
 * @package FullRent\Core\Contract\Events
 * @author Simon Bennett <simon@bennett.im>
 */
final class ContractRentInformationDrafted implements SerializableInterface
{
    /**
     * @var ContractId
     */
    private $contractId;
    /**
     * @var Rent
     */
    private $rent;
    /**
     * @var Deposit
     */
    private $deposit;
    /**
     * @var DateTime
     */
    private $draftedAt;

    /**
     * @param ContractId $contractId
     * @param Rent $rent
     * @param Deposit $deposit
     * @param DateTime $draftedAt
     */
    public function __construct(ContractId $contractId, Rent $rent, Deposit $deposit, DateTime $draftedAt)
    {
        $this->contractId = $contractId;
        $this->rent = $rent;
        $this->deposit = $deposit;
        $this->draftedAt = $draftedAt;
    }

    /**
     * @return ContractId
     */
    public function getContractId()
    {
        return $this->contractId;
    }

    /**
     * @return Rent
     */
    public function getRent()
    {
        return $this->rent;
    }

    /**
     * @return Deposit
     */
    public function getDeposit()
    {
        return $this->deposit;
    }

    /**
     * @param array $data
     * @return mixed The object instance
     */
    public static function deserialize(array $data)
    {
        return new static(new ContractId($data['contract_id']),
                          Rent::deserialize($data['rent']),
                          Deposit::deserialize($data['deposit']),
                          DateTime::deserialize($data['drafted_at']));
    }

    /**
     * @return array
     */
    public function serialize()
    {
        return [
            'contract_id' => (string)$this->contractId,
            'rent'        => $this->rent->serialize(),
            'deposit'     => $this->deposit->serialize(),
            'drafted_at'  => $this->draftedAt->serialize(),
        ];
    }
}