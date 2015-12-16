<?php
namespace FullRent\Core\Projections\AuthProjection\Queries;

/**
 * Class FindAuthByEmailQuery
 * @package FullRent\Core\Projections\AuthProjection\Queries
 * @author Simon Bennett <simon@bennett.im>
 */
final class FindAuthByEmailQuery
{
    private $email;

    /**
     * FindAuthByEmailQuery constructor.
     * @param $email
     */
    public function __construct($email)
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }


}