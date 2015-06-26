<?php
namespace FullRent\Core\RentBook\Events;

use Broadway\Serializer\SerializableInterface;
use FullRent\Core\RentBook\ValueObjects\ContractId;
use FullRent\Core\RentBook\ValueObjects\RentAmount;
use FullRent\Core\RentBook\ValueObjects\RentBookId;
use FullRent\Core\RentBook\ValueObjects\TenantId;
use FullRent\Core\ValueObjects\DateTime;

/**
 * Class RentBookOpenedAutomatic
 * @package FullRent\Core\RentBook\Events
 * @author Simon Bennett <simon@bennett.im>
 */
final class RentBookOpenedAutomatic implements SerializableInterface
{
    /**
     * @var RentBookId
     */
    private $rentBookId;
    /**
     * @var ContractId
     */
    private $contractId;
    /**
     * @var TenantId
     */
    private $tenantId;
    /**
     * @var RentAmount
     */
    private $rentAmount;
    /**
     * @var DateTime
     */
    private $openedAt;

    /**
     * @param RentBookId $rentBookId
     * @param ContractId $contractId
     * @param TenantId $tenantId
     * @param RentAmount $rentAmount
     * @param DateTime $openedAt
     */
    public function __construct(
        RentBookId $rentBookId,
        ContractId $contractId,
        TenantId $tenantId,
        RentAmount $rentAmount,
        DateTime $openedAt
    ) {
        $this->rentBookId = $rentBookId;
        $this->contractId = $contractId;
        $this->tenantId = $tenantId;
        $this->rentAmount = $rentAmount;
        $this->openedAt = $openedAt;
    }

    /**
     * @return RentBookId
     */
    public function getRentBookId()
    {
        return $this->rentBookId;
    }

    /**
     * @return ContractId
     */
    public function getContractId()
    {
        return $this->contractId;
    }

    /**
     * @return TenantId
     */
    public function getTenantId()
    {
        return $this->tenantId;
    }

    /**
     * @return RentAmount
     */
    public function getRentAmount()
    {
        return $this->rentAmount;
    }

    /**
     * @return DateTime
     */
    public function getOpenedAt()
    {
        return $this->openedAt;
    }

    /**
     * @param array $data
     * @return mixed The object instance
     */
    public static function deserialize(array $data)
    {
        return new static(new RentBookId($data['rent_book_id']),
                          new ContractId($data['contract_id']),
                          new TenantId($data['tenant_id']),
                          RentAmount::deserialize($data['rent']),
                          DateTime::deserialize($data['opened_at']));
    }

    /**
     * @return array
     */
    public function serialize()
    {
        return [
            'rent_book_id' => (string)$this->rentBookId,
            'contract_id'  => (string)$this->contractId,
            'tenant_id'    => (string)$this->tenantId,
            'rent'         => $this->rentAmount->serialize(),
            'opened_at'    => $this->openedAt->serialize(),
        ];
    }
}