<?php
namespace FullRent\Core\Contract\ValueObjects;

use InvalidArgumentException;

/**
 * Class RentDueDay
 * @package FullRent\Core\Contract\ValueObjects
 * @author Simon Bennett <simon@bennett.im>
 */
final class RentDueDay
{
    /**
     * @var int
     */
    private $rentDueDay;

    /**
     * @param $rentDueDay
     */
    public function __construct($rentDueDay)
    {
        if (!is_integer($rentDueDay)) {
            throw new InvalidArgumentException("Rent Due Day needs to be a int");
        }

        if ($rentDueDay < 1 || $rentDueDay > 28) {
            throw new InvalidArgumentException("Rent Due Day needs to be between 1 and 28");
        }


        $this->rentDueDay = $rentDueDay;
    }

    /**
     * @return int
     */
    public function getRentDueDay()
    {
        return $this->rentDueDay;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string)$this->rentDueDay;
    }


}