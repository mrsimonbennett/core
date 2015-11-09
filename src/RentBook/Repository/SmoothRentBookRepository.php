<?php
namespace FullRent\Core\RentBook\Repository;

use FullRent\Core\RentBook\RentBook;
use SmoothPhp\EventSourcing\EventSourcedRepository;

/**
 * Class SmoothRentBookRepository
 * @package FullRent\Core\RentBook\Repository
 * @author Simon Bennett <simon@bennett.im>
 */
final class SmoothRentBookRepository extends EventSourcedRepository implements RentBookRepository
{

    /**
     * @return string
     */
    protected function getPrefix()
    {
        return 'rent_book-';
    }

    protected function getAggregateType()
    {
        return RentBook::class;
    }
}