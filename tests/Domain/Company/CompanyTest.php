<?php

use FullRent\Core\Company\Company;
use FullRent\Core\Company\Events\CompanyHasBeenRegistered;

/**
 * Class CompanyTest
 * @author Simon Bennett <simon@bennett.im>
 */
final class CompanyTest extends TestCase
{
    /**
     *
     */
    public function testMakingCompany()
    {
        $company = $this->makeCompany();
        $events = $company->getUncommittedEvents()->getIterator();

        $this->assertCount(1, $events);
        $this->assertInstanceOf(CompanyHasBeenRegistered::class, $events[0]->getPayload());
    }

    public function testAttachingLandlord()
    {
        $company = $this->makeCompany();

        $company->enrolLandlord(new \FullRent\Core\Company\Landlord(\FullRent\Core\Company\ValueObjects\LandlordId::random()));
        $events = $company->getUncommittedEvents()->getIterator();

        $this->assertCount(2, $events);
        $this->assertInstanceOf(\FullRent\Core\Company\Events\LandlordEnrolled::class, $events[1]->getPayload());
    }

    /**
     * @return Company
     */
    protected function makeCompany()
    {
        $company = Company::registerCompany(\FullRent\Core\Company\ValueObjects\CompanyId::random(),
            new \FullRent\Core\Company\ValueObjects\CompanyName('FullRent'),
            new \FullRent\Core\Company\ValueObjects\CompanyDomain('fullrent'));

        return $company;
    }
}