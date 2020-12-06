<?php

/**
 * This file is part of the DevsCast project
 *
 * (c) bernard-ng <ngandubernard@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Notification;

use App\Data\ContactRequestData;
use Psr\Log\LoggerInterface;
use Swift_Mailer;
use Twig\Environment;

/**
 * Class ContactNotification
 * @package App\Notification
 * @author bernard-ng <ngandubernard@gmail.com>
 */
class ContactNotification
{

    private Swift_Mailer $mailer;

    private Environment $twig;

    private LoggerInterface $logger;

    /**
     * ContactNotification constructor.
     * @param Swift_Mailer $mailer
     * @param Environment $twig
     * @param LoggerInterface $logger
     */
    public function __construct(Swift_Mailer $mailer, Environment $twig, LoggerInterface $logger)
    {
        $this->mailer = $mailer;
        $this->twig = $twig;
        $this->logger = $logger;
    }

    /**
     * @param ContactRequestData $contact
     * @return bool
     * @author bernard-ng <ngandubernard@gmail.com>
     */
    public function notify(ContactRequestData $contact): bool
    {
        try {
            $message = (new \Swift_Message())
                ->setFrom("noreply@devs-cast.com", "Devscast")
                ->setDate(new \DateTime('now'))
                ->setSubject($contact->subject)
                ->setReplyTo($contact->email, $contact->name)
                ->setCc($contact->email, $contact->name)
                ->setTo("contact@devs-cast.com")
                ->setBody(
                    $this->twig->render("mail/contact.html.twig", [
                        'name' => $contact->name,
                        'email' => $contact->email,
                        'subject' => $contact->subject,
                        'message' => $contact->message,
                    ]),
                    'text/html'
                );

            return $this->mailer->send($message);
        } catch (\Exception $e) {
            $this->logger->error($e->getMessage(), $e->getTrace());
            return 0;
        }
    }
}
