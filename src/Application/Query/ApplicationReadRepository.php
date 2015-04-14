<?php
namespace FullRent\Core\Application\Query;

use FullRent\Core\Application\Exceptions\ApplicationNotFoundException;
use FullRent\Core\Application\ValueObjects\ApplicantId;
use FullRent\Core\Application\ValueObjects\ApplicationId;
use FullRent\Core\Application\ValueObjects\PropertyId;

/**
 * Interface ApplicationReadRepository
 * @package FullRent\Core\Application\Query
 * @author Simon Bennett <simon@bennett.im>
 */
interface ApplicationReadRepository
{
    /**
     * @param ApplicantId $applicantId
     * @param PropertyId $propertyId
     * @return \stdClass
     */
    public function getForApplicant(ApplicantId $applicantId, PropertyId $propertyId);

    /**
     * @param ApplicationId $applicantId
     * @throws ApplicationNotFoundException
     * @return \stdClass
     */
    public function getById(ApplicationId $applicantId);

    /**
     * @param PropertyId $propertyId
     * @return  \stdClass
     */
    public function finishedByProperty(PropertyId $propertyId);


}