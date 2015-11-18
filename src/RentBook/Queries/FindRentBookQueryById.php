<?php
namespace FullRent\Core\RentBook\Queries;

/**
 * Class FindRentBookQueryById
 * @package FullRent\Core\RentBook\Queries
 * @author Simon Bennett <simon@bennett.im>
 */
final class FindRentBookQueryById
{
    /** @var string */
    private $rentBookId;

    /** @var bool */
    private $details;

    /**
     * @param string $rentBookId
     * @param bool $details
     */
    public function __construct($rentBookId, $details = false)
    {
        $this->rentBookId = $rentBookId;
        $this->details = $details;
    }

    /**
     * @return string
     */
    public function getRentBookId()
    {
        return $this->rentBookId;
    }

    /**
     * @return boolean
     */
    public function isDetails()
    {
        return $this->details;
    }


}