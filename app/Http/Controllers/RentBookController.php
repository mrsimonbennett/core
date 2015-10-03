<?php
namespace FullRent\Core\Application\Http\Controllers;

use FullRent\Core\QueryBus\QueryBus;
use FullRent\Core\RentBook\Queries\FindRentBookQueryById;
use Illuminate\Routing\Controller;

/**
 * Class RentBookController
 * @package FullRent\Core\Application\Http\Controllers
 * @author Simon Bennett <simon@bennett.im>
 */
final class RentBookController extends Controller
{
    /** @var QueryBus */
    private $queryBus;

    /**
     * RentBookController constructor.
     * @param QueryBus $queryBus
     */
    public function __construct(QueryBus $queryBus)
    {
        $this->queryBus = $queryBus;
    }
    public function getRentBook($rentBookId)
    {
        return (array)$this->queryBus->query(new FindRentBookQueryById($rentBookId,true));
    }
}