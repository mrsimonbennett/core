<?php namespace FullRent\Core\Application\Http\Controllers\Properties;

use Illuminate\Routing\Controller;
use FullRent\Core\QueryBus\QueryBus;
use SmoothPhp\Contracts\CommandBus\CommandBus;
use FullRent\Core\Documents\Exception\DocumentsNotFound;
use FullRent\Core\Application\Http\Helpers\JsonResponse;
use FullRent\Core\Documents\Queries\FindDocumentsByPropertyId;

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
        try {
            return $this->json->success($this->query->query(new FindDocumentsByPropertyId($propertyId)));
        } catch (DocumentsNotFound $e) {
            return $this->json->error([$e->getMessage()]);
        }
    }
}