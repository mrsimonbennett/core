<?php
namespace FullRent\Core\Application\Query;

use FullRent\Core\Application\Exceptions\ApplicationNotFoundException;
use FullRent\Core\Application\ValueObjects\ApplicantId;
use FullRent\Core\Application\ValueObjects\ApplicationId;
use FullRent\Core\Application\ValueObjects\PropertyId;
use FullRent\Core\Infrastructure\Subscribers\BaseMysqlSubscriber;

/**
 * Class MysqlApplicationReadRepository
 * @package FullRent\Core\Application\Query
 * @author Simon Bennett <simon@bennett.im>
 */
final class MysqlApplicationReadRepository extends BaseMysqlSubscriber implements ApplicationReadRepository
{

    /**
     * @param ApplicantId $applicantId
     * @param PropertyId $propertyId
     * @return \stdClass
     */
    public function getForApplicant(ApplicantId $applicantId, PropertyId $propertyId)
    {
        return $this->db->table('applications')->where('applicant_id', $applicantId)->first();
    }

    /**
     * @param ApplicationId $applicantId
     * @throws ApplicationNotFoundException
     * @return \stdClass
     */
    public function getById(ApplicationId $applicantId)
    {
        if (is_null($application = $this->db->table('applications')->where('id', $applicantId)->first())) {
            throw new ApplicationNotFoundException;
        }
        $application->applicant = $this->db->table('users')->where('id', $application->applicant_id)->first();
        $application->property = $this->db->table('properties')->where('id', $application->property_id)->first();
        return $application;
    }

    /**
     * @param PropertyId $propertyId
     * @return  \stdClass
     */
    public function finishedByProperty(PropertyId $propertyId)
    {
        $applications = $this->db
            ->table('applications')
            ->where('property_id', $propertyId)
            ->where('finished',true)
            ->get();
        foreach($applications as $key => $application) {
            $applications[$key]->applicant = $this->db->table('users')->where('id', $application->applicant_id)->first();
        }
        return $applications;
    }
}