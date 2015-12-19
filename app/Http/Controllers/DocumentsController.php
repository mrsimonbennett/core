<?php namespace FullRent\Core\Application\Http\Controllers;

use FullRent\Core\Documents\ValueObjects\DocumentType;
use FullRent\Core\Application\Http\Helpers\JsonResponse;

/**
 * Class DocumentsController
 *
 * @author jrdn hannah <jrdn@jrdnhannah.co.uk>
 */
final class DocumentsController extends Controller
{
    /** @var JsonResponse */
    private $json;

    /**
     * DocumentsController constructor.
     *
     * @param JsonResponse $json
     */
    public function __construct(JsonResponse $json)
    {
        $this->json = $json;
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function documentTypes()
    {
        return $this->json->success(['types' => DocumentType::types()]);
    }
}