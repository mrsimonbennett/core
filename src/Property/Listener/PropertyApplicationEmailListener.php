<?php
namespace FullRent\Core\Property\Listener;

use FullRent\Core\Company\Queries\FindCompanyByIdQuery;
use FullRent\Core\Infrastructure\Email\EmailClient;
use FullRent\Core\Infrastructure\Events\EventListener;
use FullRent\Core\Property\Events\ApplicantInvitedToApplyByEmail;
use FullRent\Core\Property\Queries\FindPropertyById;
use FullRent\Core\QueryBus\QueryBus;
use FullRent\Core\User\Queries\FindUserById;

/**
 * Class PropertyApplicationEmailListener
 * @package FullRent\Core\Property\Listener
 * @author Simon Bennett <simon@bennett.im>
 */
final class PropertyApplicationEmailListener extends EventListener
{
    /**
     * @var QueryBus
     */
    private $queryBus;

    /**
     * @var EmailClient
     */
    private $mailer;

    /**
     * @param QueryBus $queryBus
     * @param EmailClient $mailer
     */
    public function __construct(QueryBus $queryBus, EmailClient $mailer)
    {
        $this->queryBus = $queryBus;
        $this->mailer = $mailer;
    }

    public function whenApplicantInvitedToApplyByEmail(ApplicantInvitedToApplyByEmail $e)
    {
        $property = $this->queryBus->query(new FindPropertyById((string)$e->getPropertyId()));
        $landlord = $this->queryBus->query(new FindUserById($property->landlord_id, false));
        $company = $this->queryBus->query(new FindCompanyByIdQuery($property->company_id));


        $this->mailer->send('applications.invitation',
                            "You have been invited to submit an application for {$property->address_firstline} by {$landlord->known_as}",
                            [
                                'landlord' => $landlord,
                                'property' => $property,
                                'company'  => $company,
                            ],
                            'Tenant',
                            $e->getApplicantEmail()->getEmail());

    }

    /**
     * @return array
     */
    protected function registerOnce()
    {
        return ['whenApplicantInvitedToApplyByEmail' => ApplicantInvitedToApplyByEmail::class];
    }

    /**
     * @return array
     */
    protected function register()
    {
        return [];
    }
}