<?php
namespace FullRent\Core\Tenancy\Listeners;

use FullRent\Core\Infrastructure\Mysql\MySqlClient;
use FullRent\Core\Tenancy\Events\InvitedExistingUserToTenancy;
use FullRent\Core\Tenancy\Events\InvitedNewUserToTenancy;
use FullRent\Core\Tenancy\Events\TenancyDrafted;
use SmoothPhp\Contracts\EventDispatcher\Projection;
use SmoothPhp\Contracts\EventDispatcher\Subscriber;

/**
 * Class TenancyMysqlListener
 * @package FullRent\Core\Tenancy\Listeners
 * @author Simon Bennett <simon@bennett.im>
 */
final class TenancyMysqlListener implements Subscriber, Projection
{
    /** @var MySqlClient */
    private $client;

    /**
     * TenancyMysqlListener constructor.
     * @param MySqlClient $client
     */
    public function __construct(MySqlClient $client)
    {
        $this->client = $client;
    }

    /**
     * @param TenancyDrafted $e
     */
    public function whenTenancyDraftedCreateRecord(TenancyDrafted $e)
    {
        $this->client->query()
                     ->table('tenancies')
                     ->insert([
                                  'id'                               => $e->getTenancyId(),
                                  'company_id'                       => $e->getCompanyId(),
                                  'property_id'                      => $e->getPropertyId(),
                                  'tenancy_start'                    => $e->getTenancyDuration()->getStart(),
                                  'tenancy_end'                      => $e->getTenancyDuration()->getEnd(),
                                  'tenancy_rent_amount'              => $e->getRentDetails()->getRentAmount()
                                                                          ->getAmountInPounds(),
                                  'tenancy_rent_frequency'           => $e->getRentDetails()->getRentFrequency()
                                                                          ->getRentFrequency(),
                                  'tenancy_rent_frequency_formatted' => $e->getRentDetails()->getRentFrequency()
                                                                          ->getRentFrequencyFormatted(),
                                  'status'                           => 'draft',
                                  'drafted_at'                       => $e->getDraftedAt()
                              ]);
    }

    /**
     * @param InvitedNewUserToTenancy $e
     */
    public function whenInvitedNewUserToTenancy(InvitedNewUserToTenancy $e)
    {
        $this->client->query()
                     ->table('tenancy_tenants')
                     ->insert([
                                  'tenant_id'  => $e->getTenantId(),
                                  'tenancy_id' => $e->getId(),
                                  'invited_at' => $e->getInvitedAt(),
                              ]);
    }

    /**
     * @param InvitedExistingUserToTenancy $e
     */
    public function whenInvitedExistingUserToTenancy(InvitedExistingUserToTenancy $e)
    {
        $this->client->query()
                     ->table('tenancy_tenants')
                     ->insert([
                                  'tenant_id'  => $e->getTenantId(),
                                  'tenancy_id' => $e->getId(),
                                  'invited_at' => $e->getInvitedAt(),
                              ]);
    }

    /**
     * @return array
     */
    public function getSubscribedEvents()
    {
        return [
            TenancyDrafted::class               => ['whenTenancyDraftedCreateRecord'],
            InvitedNewUserToTenancy::class      => ['whenInvitedNewUserToTenancy'],
            InvitedExistingUserToTenancy::class => ['whenInvitedExistingUserToTenancy']
        ];
    }
}