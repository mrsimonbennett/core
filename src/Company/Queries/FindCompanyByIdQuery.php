<?php
namespace FullRent\Core\Company\Queries;

/**
 * Class FindCompanyByIdQuery
 * @package FullRent\Core\Company\Queries
 * @author Simon Bennett <simon@bennett.im>
 */
final class FindCompanyByIdQuery
{
    /**
     * @var string
     */
    private $companyId;

    /**
     * @param string $companyId
     */
    public function __construct($companyId)
    {
        $this->companyId = $companyId;
    }

    /**
     * @return string
     */
    public function getCompanyId()
    {
        return $this->companyId;
    }

}