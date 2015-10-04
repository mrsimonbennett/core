<?php
namespace FullRent\Core\Company\Commands;

/**
 * Class ChangeCompanyDomain
 * @package FullRent\Core\Company\Commands
 * @author Simon Bennett <simon@bennett.im>
 */
final class ChangeCompanyDomain
{
    /** @var string */
    private $companyId;

    /** @var string */
    private $companyDomain;

    /**
     * ChangeCompanyDomain constructor.
     * @param string $companyId
     * @param string $companyDomain
     */
    public function __construct($companyId, $companyDomain)
    {
        $this->companyId = $companyId;
        $this->companyDomain = $companyDomain;
    }

    /**
     * @return string
     */
    public function getCompanyId()
    {
        return $this->companyId;
    }

    /**
     * @return string
     */
    public function getCompanyDomain()
    {
        return $this->companyDomain;
    }

}