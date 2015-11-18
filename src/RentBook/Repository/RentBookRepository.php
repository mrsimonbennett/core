<?php
namespace FullRent\Core\RentBook\Repository;

use FullRent\Core\RentBook\RentBook;
use FullRent\Core\RentBook\ValueObjects\RentBookId;
use SmoothPhp\Contracts\EventSourcing\AggregateRoot;

/**
 * Interface RentBookRepository
 * @package FullRent\Core\RentBook\Repository
 * @author Simon Bennett <simon@bennett.im>
 */
interface RentBookRepository
{
    /**
     * @param RentBookId $id
     * @return RentBook
     */
    public function load($id);

    /**
     * @param AggregateRoot $aggregateRoot
     * @return void
     */
    public function save(AggregateRoot $aggregateRoot);
}