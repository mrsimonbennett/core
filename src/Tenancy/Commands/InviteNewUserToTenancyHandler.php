<?php
namespace FullRent\Core\Tenancy\Commands;

use FullRent\Core\Tenancy\Repositories\TenancyRepository;
use FullRent\Core\Tenancy\ValueObjects\TenancyId;
use FullRent\Core\Tenancy\ValueObjects\TenantEmail;
use FullRent\Core\Tenancy\ValueObjects\TenantId;

/**
 * Class InviteNewUserToTenancyHandler
 * @package FullRent\Core\Tenancy\Commands
 * @author Simon Bennett <simon@bennett.im>
 */
final class InviteNewUserToTenancyHandler
{
    /** @var TenancyRepository */
    private $tenancyRepository;

    /**
     * InviteNewUserToTenancyHandler constructor.
     * @param TenancyRepository $tenancyRepository
     */
    public function __construct(TenancyRepository $tenancyRepository)
    {
        $this->tenancyRepository = $tenancyRepository;
    }

    /**
     * @param InviteNewUserToTenancy $command
     */
    public function handle(InviteNewUserToTenancy $command)
    {
        $tenancy = $this->tenancyRepository->load(new TenancyId($command->getTenancyId()));

        $tenancy->inviteNewUser(new TenantId($command->getUserId()), new TenantEmail($command->getUserEmail()));

        $this->tenancyRepository->save($tenancy);
    }
}