<?php
namespace FullRent\Core\Company\Events;

use SmoothPhp\Contracts\Serialization\Serializable;
use FullRent\Core\Company\ValueObjects\CompanyDomain;
use FullRent\Core\Company\ValueObjects\CompanyId;
use FullRent\Core\ValueObjects\DateTime;

/**
 * Class CompanyDomainChanged
 * @package FullRent\Core\Company\Events
 * @author Simon Bennett <simon@bennett.im>
 */
final class CompanyDomainChanged implements Serializable, \SmoothPhp\Contracts\EventSourcing\Event
{
    /** @var CompanyId */
    private $companyId;

    /** @var CompanyDomain */
    private $companyDomain;

    /** @var DateTime */
    private $changedAt;

    /**
     * CompanyDomainChanged constructor.
     * @param CompanyId $companyId
     * @param CompanyDomain $companyDomain
     * @param DateTime $changedAt
     */
    public function __construct(CompanyId $companyId, CompanyDomain $companyDomain, DateTime $changedAt)
    {
        $this->companyId = $companyId;
        $this->companyDomain = $companyDomain;
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
     * @return CompanyDomain
     */
    public function getCompanyDomain()
    {
        return $this->companyDomain;
    }

    /**
     * @return DateTime
     */
    public function getChangedAt()
    {
        return $this->changedAt;
    }

    /**
     * @param array $data
     * @return mixed The object instance
     */
    public static function deserialize(array $data)
    {
        return new static(new CompanyId($data['company_id']),
                          CompanyDomain::deserialize($data['company_domain']),
                          DateTime::deserialize($data['changed_at']));
    }

    /**
     * @return array
     */
    public function serialize()
    {
        return [
            'company_id'     => (string)$this->companyId,
            'company_domain' => $this->companyDomain->serialize(),
            'changed_at'     => $this->changedAt->serialize()
        ];
    }
}