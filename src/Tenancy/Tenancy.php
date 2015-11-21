<?php
namespace FullRent\Core\Tenancy;

use FullRent\Core\Tenancy\Events\TenancyDrafted;
use FullRent\Core\Tenancy\ValueObjects\CompanyId;
use FullRent\Core\Tenancy\ValueObjects\PropertyId;
use FullRent\Core\Tenancy\ValueObjects\RentDetails;
use FullRent\Core\Tenancy\ValueObjects\TenancyDuration;
use FullRent\Core\Tenancy\ValueObjects\TenancyId;
use FullRent\Core\ValueObjects\DateTime;
use SmoothPhp\EventSourcing\AggregateRoot;

/**
 * Class Tenancy
 * @package FullRent\Core\Tenancy
 * @author Simon Bennett <simon@bennett.im>
 */
final class Tenancy extends AggregateRoot
{
    /**
     * @var TenancyId
     */
    private $tenancyId;

    /**
     * @param TenancyId $tenancyId
     * @param PropertyId $propertyId
     * @param CompanyId $companyId
     * @param TenancyDuration $tenancyDuration
     * @param RentDetails $rentDetails
     * @return static
     */
    public static function draft(
        TenancyId $tenancyId,
        PropertyId $propertyId,
        CompanyId $companyId,
        TenancyDuration $tenancyDuration,
        RentDetails $rentDetails
    ) {
        $tenancy = new static();
        $tenancy->apply(new TenancyDrafted($tenancyId, $propertyId, $companyId,$tenancyDuration, $rentDetails, new DateTime()));

        return $tenancy;
    }


    public function applyTenancyDrafted(TenancyDrafted $e)
    {
        $this->tenancyId = $e->getTenancyId();
    }

    /**
     * @return string
     */
    public function getAggregateRootId()
    {
        return 'tenancy-' . $this->tenancyId;
    }
}