<?php
namespace FullRent\Core\Company\ValueObjects;

use Broadway\Serializer\SerializableInterface;

/**
 * Class CompanyDomain
 * @package FullRent\Core\Company\ValueObjects
 * @author Simon Bennett <simon@bennett.im>
 */
final class CompanyDomain implements SerializableInterface
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

    /**
     * @return mixed The object instance
     */
    public static function deserialize(array $data)
    {
        return new static($data['domain']);
    }

    /**
     * @return array
     */
    public function serialize()
    {
        return ['domain' => $this->domain];
    }

    /**
     * @return string
     */
    function __toString()
    {
        return (string)$this->domain;
    }

}