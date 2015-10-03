<?php
namespace FullRent\Core\Application\Http\Controllers\GoCardless;

use FullRent\Core\CommandBus\CommandBus;
use FullRent\Core\QueryBus\QueryBus;
use FullRent\Core\RentBook\Commands\CancelRentBookBill;
use FullRent\Core\RentBook\Commands\CancelRentBookPreAuth;
use FullRent\Core\RentBook\Commands\CreatingRentBookBill;
use FullRent\Core\RentBook\Commands\ExpireRentBookPreAuth;
use FullRent\Core\RentBook\Commands\FailRentBookBill;
use FullRent\Core\RentBook\Commands\PayRentBookBill;
use FullRent\Core\RentBook\Commands\WithdrawRentBookBill;
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

    /** @var CommandBus */
    private $commandBus;

    /**
     * GoCardlessWebHooksController constructor.
     * @param QueryBus $queryBus
     * @param CommandBus $commandBus
     */
    public function __construct(QueryBus $queryBus, CommandBus $commandBus)
    {
        $this->queryBus = $queryBus;
        \GoCardless::$environment = env('CARDLESS_ENV');

        $this->commandBus = $commandBus;
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
                        switch ($payload['action']) {
                            case 'created':
                                $this->commandBus->execute(new CreatingRentBookBill($bill['source_id'], $bill['id']));
                                break;
                            case 'failed':
                                $this->commandBus->execute(new FailRentBookBill($bill['source_id'], $bill['id']));
                                break;
                            case 'cancelled':
                                $this->commandBus->execute(new CancelRentBookBill($bill['source_id'], $bill['id']));
                                break;
                            case 'paid':
                                $this->commandBus->execute(new PayRentBookBill($bill['source_id'],
                                                                               $bill['id'],
                                                                               $bill['paid_at']));
                                break;
                            case 'withdrawn':
                                $this->commandBus->execute(new WithdrawRentBookBill( $bill['id'],$bill['source_id']));
                                break;
                        }
                    }
                    break;
                case 'pre_authorization':
                    foreach ($payload['pre_authorizations'] as $preAuth) {
                        if ($payload['action'] == 'cancelled') {
                            $this->commandBus->execute(new CancelRentBookPreAuth($preAuth['id']));
                        } elseif ($payload['action'] == 'expired') {
                            $this->commandBus->execute(new ExpireRentBookPreAuth($preAuth['id']));
                        }
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