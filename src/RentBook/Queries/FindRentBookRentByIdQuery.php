<?php
namespace FullRent\Core\RentBook\Queries;

/**
 * Class FindRentBookRentByIdQuery
 * @package FullRent\Core\RentBook\Queries
 * @author Simon Bennett <simon@bennett.im>
 */
final class FindRentBookRentByIdQuery
{
    /** @var string */
    private $rentId;

    /** @var bool */
    private $details;

    /**
     * FindRentBookRentByIdQuery constructor.
     * @param string $rentId
     * @param bool $details
     */
    public function __construct($rentId, $details)
    {
        $this->rentId = $rentId;
        $this->details = $details;
    }

    /**
     * @return string
     */
    public function getRentId()
    {
        return $this->rentId;
    }

    /**
     * @return boolean
     */
    public function isDetails()
    {
        return $this->details;
    }

}