<?php
namespace FullRent\Core\Application\Http\Controllers\GoCardless;

use FullRent\Core\Company\Queries\FindCompanyByIdQuery;
use FullRent\Core\QueryBus\QueryBus;
use GoCardless_Client;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

/**
 * Class GoCardlessWebHooksController
 * @package FullRent\Core\Application\Http\Controllers\GoCardless
 * @author Simon Bennett <simon@bennett.im>
 */
final class GoCardlessWebHooksController extends Controller
{
    /** @var QueryBus */
    private $queryBus;

    /**
     * GoCardlessWebHooksController constructor.
     * @param QueryBus $queryBus
     */
    public function __construct(QueryBus $queryBus)
    {
        $this->queryBus = $queryBus;
        \GoCardless::$environment = env('CARDLESS_ENV');

    }

    public function hook(Request $request)
    {
       // $company = $this->queryBus->query(new FindCompanyByIdQuery($request->company_id));


        $client = $this->buildClient();

        $webhook = file_get_contents('php://input');
        $webhookArray = json_decode($webhook, true);

        if ($client->validate_webhook($webhookArray['payload'])) {
            \Log::debug($webhookArray);
        }

        return new Response('Invalid signature', 403);
    }

    /**
     * @param $company
     */
    protected function buildClient()
    {
        return new GoCardless_Client(
            [
                'app_id'       => getenv('CARDLESS_APP'),
                'app_secret'   => getenv('CARDLESS_SECRET'),

            ]
        );
    }
}