<?php
namespace FullRent\Core\Company\Events;

use SmoothPhp\Contracts\Serialization\Serializable;
use FullRent\Core\Company\ValueObjects\CompanyDomain;
use FullRent\Core\Company\ValueObjects\CompanyId;
use FullRent\Core\Company\ValueObjects\CompanyName;
use FullRent\Core\ValueObjects\DateTime;

/**
 * Class CompanyHasBeenRegistered
 * @package FullRent\Core\CompanyModal\Events
 * @author Simon Bennett <simon@bennett.im>
 */
final class CompanyHasBeenRegistered implements Serializable, \SmoothPhp\Contracts\EventSourcing\Event
{
    /**
     * @var CompanyId
     */
    private $companyId;
    /**
     * @var CompanyName
     */
    private $companyName;
    /**
     * @var CompanyDomain
     */
    private $companyDomain;
    /**
     * @var DateTime
     */
    private $createdAt;

    /**
     * @param CompanyId $companyId
     * @param CompanyName $companyName
     * @param CompanyDomain $companyDomain
     * @param DateTime $createdAt
     */
    public function __construct(
        CompanyId $companyId,
        CompanyName $companyName,
        CompanyDomain $companyDomain,
        DateTime $createdAt
    ) {
        $this->companyId = $companyId;
        $this->companyName = $companyName;
        $this->companyDomain = $companyDomain;
        $this->createdAt = $createdAt;
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
     * @return CompanyDomain
     */
    public function getCompanyDomain()
    {
        return $this->companyDomain;
    }

    /**
     * @return DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @return mixed The object instance
     */
    public static function deserialize(array $data)
    {
        return new static(new CompanyId($data['id']), CompanyName::deserialize($data['name']),
            CompanyDomain::deserialize($data['domain']),
            DateTime::deserialize($data['created_at']));
    }

    /**
     * @return array
     */
    public function serialize()
    {
        return [
            'id' => (string)$this->companyId,
            'name' => $this->companyName->serialize(),
            'domain' => $this->companyDomain->serialize(),
            'created_at' => $this->createdAt->serialize(),
        ];
    }


}