<?php
namespace FullRent\Core\Application\Http\Controllers\GoCardless;

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

        $payload = $webhookArray['payload'];
        if ($client->validate_webhook($payload)) {

            $resourceType = $payload['resource_type'];
            \Log::debug('Action: ' . $payload['action']);

            switch ($resourceType) {
                case 'bill':
                    foreach ($payload['bills'] as $bill) {
                        \Log::debug($bill);
                    }
                    break;
                case 'pre_authorization':
                    foreach ($payload['pre_authorization'] as $preAuth) {
                        \Log::debug($preAuth);
                    }

                    break;

            }


            return new Response('Invalid signature', 200);

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
                'app_id'     => getenv('CARDLESS_APP'),
                'app_secret' => getenv('CARDLESS_SECRET'),

            ]
        );
    }
}