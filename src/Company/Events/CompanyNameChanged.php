<?php
namespace FullRent\Core\Company\Events;

use SmoothPhp\Contracts\Serialization\Serializable;
use FullRent\Core\Company\ValueObjects\CompanyId;
use FullRent\Core\Company\ValueObjects\CompanyName;
use FullRent\Core\ValueObjects\DateTime;

/**
 * Class CompanyNameChanged
 * @package FullRent\Core\Company\Events
 * @author Simon Bennett <simon@bennett.im>
 */
final class CompanyNameChanged implements Serializable, \SmoothPhp\Contracts\EventSourcing\Event
{
    /** @var CompanyId */
    private $companyId;

    /** @var CompanyName */
    private $companyName;

    /** @var DateTime */
    private $changedAt;

    /**
     * CompanyNameChanged constructor.
     * @param CompanyId $companyId
     * @param CompanyName $companyName
     * @param DateTime $changedAt
     */
    public function __construct(CompanyId $companyId, CompanyName $companyName, DateTime $changedAt)
    {
        $this->companyId = $companyId;
        $this->companyName = $companyName;
        $this->changedAt = $changedAt;
    }

    /**
     * @return CompanyId
     */
    public function getCompanyId()
    {
        return $this->companyId;
    }

    /**
     * @return CompanyName
     */
    public function getCompanyName()
    {
        return $this->companyName;
    }

    /**
     * @return DateTime
     */
    public function getChangedAt()
    {
        return $this->changedAt;
    }

    /**
     * @return mixed The object instance
     */
    public static function deserialize(array $data)
    {
        return new static(new CompanyId($data['company_id']),
                          CompanyName::deserialize($data['company_name']),
                          DateTime::deserialize($data['changed_at']));
    }

    /**
     * @return array
     */
    public function serialize()
    {
        return [
            'company_id'   => (string)$this->companyId,
            'company_name' => $this->companyName->serialize(),
            'changed_at'   => $this->changedAt->serialize()
        ];
    }
}