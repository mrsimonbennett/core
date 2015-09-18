<?php
namespace FullRent\Core\Company\Queries;

/**
 * Class FindCompanyByDomainQuery
 * @package FullRent\Core\Company\Queries
 * @author Simon Bennett <simon@bennett.im>
 */
final class FindCompanyByDomainQuery
{
    /** @var string */
    private $domain;

    /**
     * FindCompanyByDomainQuery constructor.
     * @param string $domain
     */
    public function __construct($domain)
    {
        $this->domain = $domain;
    }

    /**
     * @return string
     */
    public function getDomain()
    {
        return $this->domain;
    }

}