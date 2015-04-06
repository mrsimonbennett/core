<?php
namespace Domain\Property;

use FullRent\Core\Property\Company;
use FullRent\Core\Property\Events\NewPropertyListed;
use FullRent\Core\Property\Events\PropertyAcceptingApplications;
use FullRent\Core\Property\Exceptions\PropertyAlreadyAcceptingApplicationsException;
use FullRent\Core\Property\Exceptions\PropertyAlreadyClosedToApplicationsException;
use FullRent\Core\Property\Landlord;
use FullRent\Core\Property\Property;
use FullRent\Core\Property\ValueObjects\Address;
use FullRent\Core\Property\ValueObjects\Bathrooms;
use FullRent\Core\Property\ValueObjects\BedRooms;
use FullRent\Core\Property\ValueObjects\CompanyId;
use FullRent\Core\Property\ValueObjects\LandlordId;
use FullRent\Core\Property\ValueObjects\Parking;
use FullRent\Core\Property\ValueObjects\Pets;
use FullRent\Core\Property\ValueObjects\PropertyId;
use FullRent\Core\ValueObjects\DateTime;

/**
 * Class PropertyTest
 * @package Domain\Property
 * @author Simon Bennett <simon@bennett.im>
 */
final class PropertyTest extends \TestCase
{
    public function testCreatingProperty()
    {
        $property = $this->buildProperty();

        $events = $this->events($property);

        $this->assertCount(1, $events);

        $this->checkCorrectEvent($events, 0, NewPropertyListed::class);
    }

    public function testAcceptingApplications()
    {
        $property = $this->buildProperty();

        $property->acceptApplications(DateTime::now());
        $events = $this->events($property);

        $this->assertCount(2, $events);

        $this->checkCorrectEvent($events, 1, PropertyAcceptingApplications::class);

        $this->setExpectedException(PropertyAlreadyAcceptingApplicationsException::class);

        $property->acceptApplications();
    }

    /**
     *
     */
    public function testClosingAcceptingApplications()
    {
        $property = $this->buildProperty();
        $this->setExpectedException(PropertyAlreadyClosedToApplicationsException::class);
        $property->closeApplications(DateTime::now());
    }

    /**
     * @return Address
     */
    protected function buildAddress()
    {
        return new Address('17 Knox Close', 'Norwich', 'Norfolk', 'UK', 'NR1 4LN');
    }

    /**
     * @return Property
     */
    protected function buildProperty()
    {
        return Property::listNewProperty(PropertyId::random(),
                                         $this->buildAddress(),
                                         new Company(CompanyId::random()),
                                         new Landlord(LandlordId::random()),
                                         new BedRooms(2),
                                         new Bathrooms(3),
                                         new Parking(2),
                                         Pets::allowedWithPermission());
    }
}