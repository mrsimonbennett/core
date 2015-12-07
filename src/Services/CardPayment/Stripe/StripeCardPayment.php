<?php
namespace FullRent\Core\Services\CardPayment\Stripe;

use FullRent\Core\Services\CardPayment\CardDetails;
use FullRent\Core\Services\CardPayment\CardPaymentGateway;
use FullRent\Core\Services\CardPayment\SuccessFullPayment;
use FullRent\Core\ValueObjects\Money\Money;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Log\Writer;
use Stripe\Charge;
use Stripe\Stripe;

/**
 * Class StripeCardPayment
 * @package FullRent\Core\Services\CardPaymentGateWay\Stripe
 * @author Simon Bennett <simon@bennett.im>
 */
final class StripeCardPayment implements CardPaymentGateway
{
    /**
     * @var Repository
     */
    private $config;
    /**
     * @var Writer
     */
    private $writer;

    /**
     * @param Repository $config
     * @param Writer $writer
     */
    public function __construct(Repository $config, Writer $writer)
    {
        $this->config = $config;
        $this->writer = $writer;
        Stripe::setApiKey($config->get('services.stripe.secret'));
    }

    /**
     * @param CardDetails $cardDetails
     * @param Money $amount
     * @param string $description
     * @return SuccessFullPayment
     */
    public function charge(CardDetails $cardDetails, Money $amount, $description)
    {
        $transaction = Charge::create(
            [
                'amount'      => $amount->getAmount(),
                'currency'    => 'gbp',
                'description' => $description,
                'card'        => $cardDetails->toStripeArray(),
            ]
        );
        $this->writer->log('info', $transaction);

        return new SuccessFullPayment($transaction['id'],
                                      'stripe',
                                      $amount,
                                      $transaction['source']['id'],
                                      (array)$transaction);
    }
}