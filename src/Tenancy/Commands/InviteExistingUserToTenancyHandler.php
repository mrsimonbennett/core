<?php namespace FullRent\Core\Tenancy\Commands;

use FullRent\Core\Tenancy\ValueObjects\TenantId;
use FullRent\Core\Tenancy\ValueObjects\TenancyId;
use FullRent\Core\Tenancy\Repositories\TenancyRepository;

/**
 * Class InviteExistingUserToTenancyHandler
 * @package FullRent\Core\Tenancy\Commands
 * @author Simon Bennett <simon@bennett.im>
 */
final class InviteExistingUserToTenancyHandler
{
    /** @var TenancyRepository */
    private $tenancyRepository;

    /**
     * InviteExistingUserToTenancyHandler constructor.
     * @param TenancyRepository $tenancyRepository
     */
    public function __construct(TenancyRepository $tenancyRepository)
    {
        $this->tenancyRepository = $tenancyRepository;
    }

    /**
     * @param InviteExistingUserToTenancy $command
     */
    public function handle(InviteExistingUserToTenancy $command)
    {
        $tenancy = $this->tenancyRepository->load(new TenancyId($command->getTenancyId()));

        $tenancy->inviteExistingUser(new TenantId($command->getTenantId()));

        $this->tenancyRepository->save($tenancy);
    }
}