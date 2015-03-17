<?php

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
        $company = \FullRent\Core\Company\Company::registerCompany(\FullRent\Core\Company\ValueObjects\CompanyId::random(),
            new \FullRent\Core\Company\ValueObjects\CompanyName('FullRent'),
            new \FullRent\Core\Company\ValueObjects\CompanyDomain('fullrent'));

        $events = $company->getUncommittedEvents()->getIterator();

        $this->assertCount(1, $events);
        $this->assertInstanceOf(CompanyHasBeenRegistered::class, $events[0]->getPayload());
    }
}