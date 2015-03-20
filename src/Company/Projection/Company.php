<?php
namespace FullRent\Core\Company\Projection;

use DateTime;

/**
 * Class Company
 * @package FullRent\Core\Company\Projection
 * @author Simon Bennett <simon@bennett.im>
 * @Doctrine\ORM\Mapping\Entity(repositoryClass="CompanyRepository")
 * @Doctrine\ORM\Mapping\Table(name="company")
 */
final class Company
{
    /**
     * @var string
     * @Doctrine\ORM\Mapping\Id
     * @Doctrine\ORM\Mapping\Column(type="string")
     */
    public $id;
    /**
     * @var string
     * @Doctrine\ORM\Mapping\Column(type="string")
     */
    public $name;
    /**
     * @var string
     * @Doctrine\ORM\Mapping\Column(type="string")
     */
    public $domain;

    /**
     * @var DateTime
     * @Doctrine\ORM\Mapping\Column(type="datetime")
     */
    public $created_at;
}