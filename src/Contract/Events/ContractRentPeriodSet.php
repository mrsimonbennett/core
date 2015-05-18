<?php
namespace FullRent\Core\Contract\Events;

use Broadway\Serializer\SerializableInterface;
use FullRent\Core\Contract\ValueObjects\ContractId;
use FullRent\Core\ValueObjects\DateTime;

/**
 * Class ContractRentPeriodSet
 * @package FullRent\Core\Contract\Events
 * @author Simon Bennett <simon@bennett.im>
 */
final class ContractRentPeriodSet implements SerializableInterface
{
    /**
     * @var ContractId
     */
    private $contractId;
    /**
     * @var DateTime
     */
    private $start;
    /**
     * @var DateTime
     */
    private $end;
    /**
     * @var DateTime
     */
    private $setAt;

    /**
     * @param ContractId $contractId
     * @param DateTime $start
     * @param DateTime $end
     * @param DateTime $setAt
     */
    public function __construct(ContractId $contractId, DateTime $start, DateTime $end, DateTime $setAt)
    {
        $this->contractId = $contractId;
        $this->start = $start;
        $this->end = $end;
        $this->setAt = $setAt;
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
    public function getStart()
    {
        return $this->start;
    }

    /**
     * @return DateTime
     */
    public function getEnd()
    {
        return $this->end;
    }

    /**
     * @return DateTime
     */
    public function getSetAt()
    {
        return $this->setAt;
    }

    /**
     * @param array $data
     * @return mixed The object instance
     */
    public static function deserialize(array $data)
    {
        if(isset($data['contact_id']))
            $data['contract_id'] = $data['contact_id'];


        return new static(new ContractId($data['contract_id']),
                          DateTime::deserialize($data['start']),
                          DateTime::deserialize($data['end']),
                          DateTime::deserialize($data['set_at']));
    }

    /**
     * @return array
     */
    public function serialize()
    {
        return [
            'contract_id' => (string)$this->contractId,
            'start'      => $this->start->serialize(),
            'end'        => $this->end->serialize(),
            'set_at'     => $this->setAt->serialize()
        ];
    }
}