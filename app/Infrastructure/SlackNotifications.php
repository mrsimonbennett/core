<?php
namespace FullRent\Core\Application\Infrastructure;

use Broadway\Domain\DomainMessage;
use Broadway\EventHandling\EventListenerInterface;
use CL\Slack\Payload\ChatPostMessagePayload;
use CL\Slack\Transport\ApiClient;

/**
 * Class SlackNotifications
 * @package FullRent\Core\Application\Infrastructure
 * @author Simon Bennett <simon@bennett.im>
 */
final class SlackNotifications implements EventListenerInterface
{

    /**
     * @param DomainMessage $domainMessage
     */
    public function handle(DomainMessage $domainMessage)
    {
        $name = explode('.', $domainMessage->getType());

        $name = preg_replace('/(?!^)[A-Z]{2,}(?=[A-Z][a-z])|[A-Z][a-z]/', ' $0', end($name));

        $client = new ApiClient('xoxp-3334625454-3334625464-3704319083-86326b');


        $payload = new ChatPostMessagePayload();
        $payload->setChannel('#events');
        $payload->setText(ucwords($name) . " ( " . str_replace('FullRent.Core.','',$domainMessage->getType()) . ")");
        $payload->setUsername('FullRent Api');
        $payload->setIconUrl('https://fullrent.co.uk/home/fullrent-home-logo.jpg');

        /** @var ChatPostMessagePayloadResponse $response */
       $client->send($payload);
    }
}