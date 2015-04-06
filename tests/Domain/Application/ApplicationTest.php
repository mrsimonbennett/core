<?php
namespace Domain\Application;

use FullRent\Core\Application\Application;
use FullRent\Core\Application\Events\ApplicantAboutInformationProvided;
use FullRent\Core\Application\Events\StartedApplication;
use FullRent\Core\Application\Exceptions\AboutInformationAlreadySubmittedException;
use FullRent\Core\Application\ValueObjects\AboutYouApplication;
use FullRent\Core\Application\ValueObjects\AboutYouDescription;
use FullRent\Core\Application\ValueObjects\ApplicantId;
use FullRent\Core\Application\ValueObjects\ApplicationId;
use FullRent\Core\Application\ValueObjects\DateOfBirth;
use FullRent\Core\Application\ValueObjects\PhoneNumber;
use FullRent\Core\Application\ValueObjects\PropertyId;

/**
 * Class ApplicationTest
 * @package Domain\Application
 * @author Simon Bennett <simon@bennett.im>
 */
final class ApplicationTest extends \TestCase
{
    public function testCreatingNewApplication()
    {
        $application = $this->buildApplication();

        $events = $this->events($application);
        $this->count($events,1);

        $this->checkCorrectEvent($events,0,StartedApplication::class);

    }

    public function testSubmittingAboutInformation()
    {
        $application = $this->buildApplication();

        $application->submitAboutInformation($this->buildAboutYouApplication());

        $events = $this->events($application);

        $this->count($events,2);

        $this->checkCorrectEvent($events,1,ApplicantAboutInformationProvided::class);

    }
    public function testSubmittingAboutInformationTwice()
    {
        $application = $this->buildApplication();

        $application->submitAboutInformation($this->buildAboutYouApplication());

        $this->setExpectedException(AboutInformationAlreadySubmittedException::class);

        $application->submitAboutInformation($this->buildAboutYouApplication());
    }
    /**
     * @return Application
     */
    protected function buildApplication()
    {
        $application = Application::startApplication(ApplicationId::random(),
                                                     ApplicantId::random(),
                                                     PropertyId::random());

        return $application;
    }

    /**
     * @return AboutYouApplication
     */
    protected function buildAboutYouApplication()
    {
        return new AboutYouApplication(new AboutYouDescription("Hi I'm simon"),
                                       new DateOfBirth("21/04/1992"),
                                       new PhoneNumber("00000"));
    }
}