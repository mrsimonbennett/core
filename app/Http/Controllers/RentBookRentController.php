<?php
namespace FullRent\Core\Application\Http\Controllers;

use FullRent\Core\QueryBus\QueryBus;
use FullRent\Core\RentBook\Queries\FindRentBookRentByIdQuery;
use Illuminate\Routing\Controller;

/**
 * Class RentBookRentController
 * @package FullRent\Core\Application\Http\Controllers
 * @author Simon Bennett <simon@bennett.im>
 */
final class RentBookRentController extends Controller
{
    /** @var QueryBus */
    private $queryBus;

    /**
     * RentBookRentController constructor.
     * @param QueryBus $queryBus
     */
    public function __construct(QueryBus $queryBus)
    {
        $this->queryBus = $queryBus;
    }
    public function getRent($rentBookId, $rentId)
    {
        return (array)$this->queryBus->query(new FindRentBookRentByIdQuery($rentId,true));

    }
}