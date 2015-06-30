<?php
namespace FullRent\Core\User\Queries;

/**
 * Class FindUserById
 * @package FullRent\Core\User\Queries
 * @author Simon Bennett <simon@bennett.im>
 */
final class FindUserById
{
    private $userId;
    /**
     * @var bool
     */
    private $withCompany;

    /**
     * @param $userId
     * @param bool $withCompany
     */
    public function __construct($userId, $withCompany = true)
    {
        $this->userId = $userId;
        $this->withCompany = $withCompany;
    }

    /**
     * @return mixed
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @return boolean
     */
    public function isWithCompany()
    {
        return $this->withCompany;
    }

}