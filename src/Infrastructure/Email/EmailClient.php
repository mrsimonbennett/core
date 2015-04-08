<?php
namespace FullRent\Core\Infrastructure\Email;

use Illuminate\Contracts\Config\Repository;
use Illuminate\Contracts\Mail\Mailer;
use Illuminate\Mail\Message;

/**
 * Class BaseEmail
 * @package FullRent\Core\Infrastructure\Email
 * @author Simon Bennett <simon@bennett.im>
 */
final class EmailClient
{
    /**
     * @var Mailer
     */
    private $mailer;
    /**
     * @var Repository
     */
    private $config;

    /**
     * @param Mailer $mailer
     * @param Repository $config
     */
    public function __construct(Mailer $mailer, Repository $config)
    {
        $this->mailer = $mailer;
        $this->config = $config;
    }

    /**
     * @param  string $template Email Template File
     * @param  string $subject
     * @param  array $data Data to inject into the view
     * @param $userName
     * @param $userEmail
     */
    public function send($template, $subject, array $data, $userName, $userEmail)
    {
        $this->mailer->send(
            'emails.' . $template,
            array_merge(['subject' => $subject], $data),
            function (Message $message) use ($subject, $userName, $userEmail) {
                $message->from($this->config->get('mail.from.address'), $this->config->get('mail.from.name'));
                $message->replyTo($this->config->get('mail.replyto.address'), $this->config->get('mail.replyto.name'));
                $message->to((string)$userEmail, (string)$userName);
                $message->subject($subject);
            }
        );
    }
}