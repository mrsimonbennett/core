<?php namespace FullRent\Core\Application\Http\Controllers\Properties;

use FullRent\Core\Documents\Queries\FindDocumentsByPropertyId;
use FullRent\Core\QueryBus\QueryBus;
use FullRent\Core\Application\Http\Helpers\JsonResponse;
use Illuminate\Routing\Controller;
use SmoothPhp\Contracts\CommandBus\CommandBus;

/**
 * Class DocumentsController
 *
 * @author jrdn hannah <jrdn@jrdnhannah.co.uk>
 */
final class DocumentsController extends Controller
{
    /** @var CommandBus */
    private $bus;
    /** @var JsonResponse */
    private $json;
    /** @var QueryBus */
    private $query;

    /**
     * @param CommandBus   $bus
     * @param JsonResponse $json
     * @param QueryBus     $query
     */
    public function __construct(CommandBus $bus, JsonResponse $json, QueryBus $query)
    {
        $this->bus = $bus;
        $this->json = $json;
        $this->query = $query;
    }

    /**
     * @param string $propertyId
     * @return \Illuminate\Http\JsonResponse
     */
    public function documentsForProperty($propertyId)
    {
        return $this->json->success($this->query->query(new FindDocumentsByPropertyId($propertyId)));
    }
}