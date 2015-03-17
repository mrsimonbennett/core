<?php
namespace FullRent\Core\Company\ValueObjects;

/**
 * Class CompanyDomain
 * @package FullRent\Core\Company\ValueObjects
 * @author Simon Bennett <simon@bennett.im>
 */
final class CompanyDomain
{
    /**
     * @var string
     */
    private $domain;

    /**
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