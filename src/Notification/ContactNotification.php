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

use App\Data\ContactData;
use Psr\Log\LoggerInterface;
use Swift_Mailer;
use Twig\Environment;

class ContactNotification
{

    /** @var Swift_Mailer */
    private $mailer;

    /** @var Environment */
    private $twig;

    /** @var LoggerInterface */
    private $logger;

    /**
     * ContactNotification constructor.
     * @param Swift_Mailer $mailer
     * @param Environment $twig
     */
    public function __construct(Swift_Mailer $mailer, Environment $twig, LoggerInterface $logger)
    {
        $this->mailer = $mailer;
        $this->twig = $twig;
        $this->logger = $logger;
    }

    /**
     * @param ContactData $contact
     * @return int
     * @author bernard-ng <ngandubernard@gmail.com>
     */
    public function notify(ContactData $contact)
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
            $this->logger->error($e->getMessage(), $e->getTrace())
            return 0;
        }
    }
}
