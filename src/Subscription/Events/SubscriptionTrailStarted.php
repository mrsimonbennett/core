<?php
namespace FullRent\Core\Subscription\Events;

use FullRent\Core\Subscription\ValueObjects\CompanyId;
use FullRent\Core\Subscription\ValueObjects\SubscriptionId;
use FullRent\Core\ValueObjects\DateTime;
use SmoothPhp\Contracts\EventSourcing\Event;
use SmoothPhp\Contracts\Serialization\Serializable;

/**
 * Class SubscriptionTrailStarted
 * @package FullRent\Core\Subscription\Events
 * @author Simon Bennett <simon@bennett.im>
 */
final class SubscriptionTrailStarted implements Serializable, Event
{
    /** @var SubscriptionId */
    private $id;

    /** @var CompanyId */
    private $companyId;

    /** @var DateTime */
    private $startedAt;

    /** @var DateTime */
    private $expiresAt;

    /**
     * SubscriptionTrailStarted constructor.
     * @param SubscriptionId $id
     * @param CompanyId $companyId
     * @param DateTime $startedAt
     * @param DateTime $expiresAt
     */
    public function __construct(SubscriptionId $id, CompanyId $companyId, DateTime $startedAt, DateTime $expiresAt)
    {
        $this->id = $id;
        $this->companyId = $companyId;
        $this->startedAt = $startedAt;
        $this->expiresAt = $expiresAt;
    }

    /**
     * @return SubscriptionId
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return CompanyId
     */
    public function getCompanyId()
    {
        return $this->companyId;
    }

    /**
     * @return DateTime
     */
    public function getStartedAt()
    {
        return $this->startedAt;
    }

    /**
     * @return DateTime
     */
    public function getExpiresAt()
    {
        return $this->expiresAt;
    }

    /**
     * @return array
     */
    public function serialize()
    {
        return [
            'id'         => (string)$this->id,
            'company_id' => (string)$this->companyId,
            'started_at'  => $this->startedAt->serialize(),
            'expires_at' => $this->expiresAt->serialize()
        ];
    }

    /**
     * @param array $data
     * @return static
     */
    public static function deserialize(array $data)
    {
        return new static(new SubscriptionId($data['id']),
                          new CompanyId($data['company_id']),
                          DateTime::deserialize($data['started_at']),
                          DateTime::deserialize($data['expires_at']));
    }


}