<?php
namespace FullRent\Core\RentBook\Queries;

/**
 * Class FindRentBookQueryById
 * @package FullRent\Core\RentBook\Queries
 * @author Simon Bennett <simon@bennett.im>
 */
final class FindRentBookQueryById
{
    private $rentBookId;

    /**
     * @param $rentBookId
     */
    public function __construct($rentBookId)
    {
        $this->rentBookId = $rentBookId;
    }

    /**
     * @return mixed
     */
    public function getRentBookId()
    {
        return $this->rentBookId;
    }

}