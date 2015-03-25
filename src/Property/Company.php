<?php
namespace FullRent\Core\Property;

use Broadway\Serializer\SerializableInterface;
use FullRent\Core\Property\ValueObjects\CompanyId;

/**
 * Class Contract
 * @package FullRent\Core\Property
 * @author Simon Bennett <simon@bennett.im>
 */
final class Company implements SerializableInterface
{
    /**
     * @var CompanyId
     */
    private $contractId;

    /**
     * @param CompanyId $contractId
     */
    public function __construct(CompanyId $contractId)
    {
        $this->contractId = $contractId;
    }

    /**
     * @return CompanyId
     */
    public function getCompanyId()
    {
        return $this->contractId;
    }

    /**
     * @return mixed The object instance
     */
    public static function deserialize(array $data)
    {
        return new static(new CompanyId($data['id']));
    }

    /**
     * @return array
     */
    public function serialize()
    {
        return ['id' => (string)$this->contractId];
    }
}