<?php namespace FullRent\Core\Application\Http\Controllers\Properties;

use Log;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use FullRent\Core\QueryBus\QueryBus;
use FullRent\Core\ValueObjects\DateTime;
use SmoothPhp\Contracts\CommandBus\CommandBus;
use FullRent\Core\Property\Commands\AttachDocument;
use FullRent\Core\Documents\Commands\UploadDocument;
use FullRent\Core\Documents\Commands\UpdateDocument;
use FullRent\Core\Application\Http\Helpers\JsonResponse;
use FullRent\Core\Documents\Queries\FindDocumentsByPropertyId;
use FullRent\Core\Application\Http\Requests\Properties\Documents\UpdatePropertyDocumentHttpRequest;

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
        return $this->json->success(['documents' => $this->query->query(new FindDocumentsByPropertyId($propertyId))]);
    }

    /**
     * TODO: Proper expiry date
     *
     * @param Request $request
     * @param string  $propertyId
     * @return \Illuminate\Http\JsonResponse
     */
    public function attachDocuments(Request $request, $propertyId)
    {
        Log::info("Attaching documents to property [$propertyId]");
        try {
            $documentIds = [];
            foreach ($request->file('file') as $file) {
                $this->bus->execute(new UploadDocument($documentIds[] = $docId = uuid(), $file, new DateTime('now +1 year'))                );
                $this->bus->execute(new AttachDocument($propertyId, $docId));
            }

            return $this->json->success(['document_ids' => $documentIds]);
        } catch (\Exception $e) {
            Log::info("Exception: [{$e->getMessage()}]");
            return $this->json->error(['message' => $e->getMessage()]);
        }
    }

    /**
     * @param UpdatePropertyDocumentHttpRequest $request
     * @param string                            $propertyId
     * @param string                            $documentId
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateDocument(UpdatePropertyDocumentHttpRequest $request, $propertyId, $documentId)
    {
        try {
            $this->bus->execute(new UpdateDocument(
                $documentId,
                $request->request->get('filename'),
                $request->request->get('expiry-date'),
                $request->request->get('document-type')
            ));

            return $this->json->success(['property_id' => $propertyId, 'document_id' => $documentId]);
        } catch (\Exception $e) {
            Log::debug(sprintf("Exception at [%s] L%d\n%s\n\n", $e->getFile(), $e->getLine(), $e->getMessage()));
            return $this->json->error(['message' => $e->getMessage()]);
        }
    }
}