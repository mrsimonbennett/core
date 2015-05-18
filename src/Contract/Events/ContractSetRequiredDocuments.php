<?php
namespace FullRent\Core\Contract\Events;

use Broadway\Serializer\SerializableInterface;
use FullRent\Core\Contract\Document;
use FullRent\Core\Contract\ValueObjects\ContractId;
use FullRent\Core\ValueObjects\DateTime;

/**
 * Class ContractSetRequiredDocuments
 * @package FullRent\Core\Contract\Events
 * @author Simon Bennett <simon@bennett.im>
 */
final class ContractSetRequiredDocuments implements SerializableInterface
{
    /**
     * @var ContractId
     */
    private $contractId;
    /**
     * @var \FullRent\Core\Contract\Document[]
     */
    private $documents;
    /**
     * @var DateTime
     */
    private $setAt;

    /**
     * @param ContractId $contractId
     * @param Document[] $documents
     * @param DateTime $setAt
     */
    public function __construct(ContractId $contractId, $documents, DateTime $setAt)
    {
        $this->contractId = $contractId;
        $this->documents = $documents;
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
     * @return Document[]
     */
    public function getDocuments()
    {
        return $this->documents;
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
        /** @var Document[] $documents */
        $documents = [];
        foreach ($data['documents'] as $document) {
            $documents[] = Document::deserialize($document);
        }

        return new static(new ContractId($data['contract_id']), $documents, DateTime::deserialize($data['set_at']));
    }

    /**
     * @return array
     */
    public function serialize()
    {
        $serialized = ['contract_id' => (string)$this->contractId, 'set_at' => $this->setAt->serialize()];
        foreach ($this->documents as $document) {
            $serialized['documents'][] = $document->serialize();
        }

        return $serialized;
    }
}