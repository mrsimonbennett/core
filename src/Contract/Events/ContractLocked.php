<?php
namespace FullRent\Core\Contract\Events;

use SmoothPhp\Contracts\Serialization\Serializable;
use FullRent\Core\Contract\ValueObjects\ContractId;
use FullRent\Core\ValueObjects\DateTime;

/**
 * Class ContractLocked
 * @package FullRent\Core\Contract\Events
 * @author Simon Bennett <simon@bennett.im>
 */
final class ContractLocked implements Serializable, \SmoothPhp\Contracts\EventSourcing\Event
{
    /**
     * @var ContractId
     */
    private $contractId;
    /**
     * @var DateTime
     */
    private $lockedAt;

    /**
     * @param ContractId $contractId
     * @param DateTime $lockedAt
     */
    public function __construct(ContractId $contractId, DateTime $lockedAt)
    {
        $this->contractId = $contractId;
        $this->lockedAt = $lockedAt;
    }

    /**
     * @return ContractId
     */
    public function getContractId()
    {
        return $this->contractId;
    }

    /**
     * @return DateTime
     */
    public function getLockedAt()
    {
        return $this->lockedAt;
    }

    /**
     * @param array $data
     * @return mixed The object instance
     */
    public static function deserialize(array $data)
    {
        return new static(new ContractId($data['contract_id']), DateTime::deserialize($data['locked_at']));
    }

    /**
     * @return array
     */
    public function serialize()
    {
        return ['contract_id' => (string)$this->contractId, 'locked_at' => $this->lockedAt->serialize()];
    }
}