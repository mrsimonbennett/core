<?php
namespace FullRent\Core\Company\Projection\Subscribers;

use Doctrine\ORM\EntityManagerInterface;
use FullRent\Core\Company\Events\CompanyHasBeenRegistered;
use FullRent\Core\Company\Projection\Company;

/**
 * Class MysqlSubscriber
 * @package FullRent\Core\Company\Projection\Subscribers
 * @author Simon Bennett <simon@bennett.im>
 */
final class MysqlSubscriber 
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManagerInterface;

    /**
     * @param EntityManagerInterface $entityManagerInterface
     */
    public function __construct(EntityManagerInterface $entityManagerInterface)
    {
        $this->entityManagerInterface = $entityManagerInterface;
    }

    /**
     * @param CompanyHasBeenRegistered $beenRegistered
     * @hears("FullRent.Core.Company.Events.CompanyHasBeenRegistered")
     */
    public function companyHasBeenRegistered(CompanyHasBeenRegistered $beenRegistered)
    {
        $company = new Company();
        $company->id = (string)$beenRegistered->getCompanyId();
        $company->name = $beenRegistered->getCompanyName()->getName();
        $company->domain = $beenRegistered->getCompanyDomain()->getDomain();
        $company->created_at = $beenRegistered->getCreatedAt();

        $this->entityManagerInterface->persist($company);
        $this->entityManagerInterface->flush();
    }
}