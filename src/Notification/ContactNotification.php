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
use Swift_Mailer;
use Twig\Environment;

class ContactNotification
{

    /** @var Swift_Mailer */
    private $mailer;

    /** @var Environment */
    private $twig;

    /**
     * ContactNotification constructor.
     * @param Swift_Mailer $mailer
     * @param Environment $twig
     */
    public function __construct(Swift_Mailer $mailer, Environment $twig)
    {
        $this->mailer = $mailer;
        $this->twig = $twig;
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
                ->setFrom("noreply@devs-cast.com")
                ->setDate(new \DateTime('now'))
                ->setSubject($contact->subject)
                ->setReplyTo($contact->email)
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
            return 0;
        }
    }
}
