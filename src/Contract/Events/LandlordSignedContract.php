<?php
namespace FullRent\Core\Contract\Events;

use Broadway\Serializer\SerializableInterface;
use FullRent\Core\Contract\ValueObjects\ContractId;
use FullRent\Core\ValueObjects\DateTime;

/**
 * Class LandlordSignedContract
 * @package FullRent\Core\Contract\Events
 * @author Simon Bennett <simon@bennett.im>
 */
final class LandlordSignedContract implements SerializableInterface
{
    /**
     * @var ContractId
     */
    private $contractId;

    /**
     * @var string
     */
    private $signature;
    /**
     * @var DateTime
     */
    private $uploadedAt;

    /**
     * @param ContractId $contractId
     * @param string $signature
     * @param DateTime $uploadedAt
     */
    public function __construct(
        ContractId $contractId,
        $signature,
        DateTime $uploadedAt
    ) {

        $this->contractId = $contractId;
        $this->signature = $signature;
        $this->uploadedAt = $uploadedAt;
    }

    /**
     * @return ContractId
     */
    public function getContractId()
    {
        return $this->contractId;
    }


    /**
     * @return string
     */
    public function getSignature()
    {
        return $this->signature;
    }

    /**
     * @return DateTime
     */
    public function getUploadedAt()
    {
        return $this->uploadedAt;
    }

    /**
     * @param array $data
     * @return mixed The object instance
     */
    public static function deserialize(array $data)
    {
        return new static(new ContractId($data['contract_id']),
                          $data['signature'],
                          DateTime::deserialize($data['uploaded_at']));
    }

    /**
     * @return array
     */
    public function serialize()
    {
        return [
            'contract_id' => (string)$this->contractId,
            'signature'   => (string)$this->signature,
            'uploaded_at' => $this->uploadedAt->serialize()
        ];
    }

}