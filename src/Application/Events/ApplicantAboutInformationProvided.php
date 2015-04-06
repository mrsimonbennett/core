<?php
namespace FullRent\Core\Application\Events;

use Broadway\Serializer\SerializableInterface;
use FullRent\Core\Application\ValueObjects\AboutYouApplication;
use FullRent\Core\Application\ValueObjects\ApplicationId;

/**
 * Class ApplicantAboutInformationProvided
 * @package FullRent\Core\Application\Events
 * @author Simon Bennett <simon@bennett.im>
 */
final class ApplicantAboutInformationProvided implements SerializableInterface
{
    /**
     * @var ApplicationId
     */
    private $applicationId;
    /**
     * @var AboutYouApplication
     */
    private $aboutYouApplication;


    /**
     * @param ApplicationId $applicationId
     * @param AboutYouApplication $aboutYouApplication
     */
    public function __construct(ApplicationId $applicationId, AboutYouApplication $aboutYouApplication)
    {
        $this->applicationId = $applicationId;
        $this->aboutYouApplication = $aboutYouApplication;
    }

    /**
     * @return ApplicationId
     */
    public function getApplicationId()
    {
        return $this->applicationId;
    }

    /**
     * @return AboutYouApplication
     */
    public function getAboutYouApplication()
    {
        return $this->aboutYouApplication;
    }


    /**
     * @param array $data
     * @return mixed The object instance
     */
    public static function deserialize(array $data)
    {
        return new static(
            new ApplicationId($data['application_id']),
            AboutYouApplication::deserialize($data['about_you_application'])
        );
    }

    /**
     * @return array
     */
    public function serialize()
    {
        return [
            'application_id'        => (string)$this->applicationId,
            'about_you_application' => $this->aboutYouApplication->serialize()
        ];
    }
}